<?php
class BespokeController extends Essential_Controller_Action
{
    private $mapper;
    private $key;
    private $results;

    public function init()
    {
        $this->key = $this->getRequest()->getParam('key');
        if (!$this->key) {
            $this->_redirect('/');
        }
        $actionName = $this->getRequest()->getActionName();
        $this->key = base64_decode(base64_decode($this->key));

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT id,name,short_description,description,image,header_image,bg_color FROM questionnaires WHERE status= 'active' and id =" . (int) $this->key;
        $stmt = $db->query($sql);
        $mainQuestion = $stmt->fetchAll();

        if (!isset($mainQuestion[0]) && $actionName != 'nofound') {
            $this->_redirect('/bespoke/nofound/key/' . base64_encode(base64_encode($this->key)));
        }

        $CompleteInfo = array();
        $this->results = $mainQuestion[0];
    }

    public function questionnaireAction()
    {
        $redirectFlage = 0;
        $this->view->headTitle('Bespoke Questionnaire');

        // Redirect if question bank not assigned
        //$this->key = $this->getRequest()->getParam('key');
        $ReferenceId = $this->getRequest()->getParam('reference');
        if (!empty($ReferenceId)) {
            $data['collectPassword'] = "1";
            $data['emailaddressvalue'] = base64_decode($ReferenceId);
        } else {
            $data['collectPassword'] = "0";
        }
        if (!$this->key) {$this->key = 0;}

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT id,name,short_description,description,image,header_image,bg_color,saveforlater FROM questionnaires WHERE id =" . $this->key;
        $stmt = $db->query($sql);
        $mainQuestion = $stmt->fetchAll();

        if (!isset($mainQuestion[0])) {
            $this->_redirect('/');
        }

        if ($this->getRequest()->isPost()) {

            //checking for password validatation
            $postData = $this->getRequest()->getPost();
            if (isset($postData['email_id']) && !empty($postData['email_id']) && isset($postData['create_password']) && !empty($postData['create_password'])) {
                $redirectFlage = 1;
                $sqlForPassword = "SELECT id FROM _user_auto_save WHERE email='" . $postData['email_id'] . "' and password ='" . trim($postData['create_password']) . "'";
                $stmtForPassword = $db->query($sqlForPassword);
                $questionPassword = $stmtForPassword->fetchAll();
                if (isset($questionPassword[0])) {
                    //getting question detial
                    $ReferenceIdValue = $questionPassword[0]['id'];
                    $sqlForQuestionTemp = "SELECT * FROM questionnaire_answers_temp WHERE referenceid='" . $ReferenceIdValue . "'";
                    $stmtForQuestionTemp = $db->query($sqlForQuestionTemp);
                    $data['tempanswer'] = $stmtForQuestionTemp->fetchAll();
                    $data['collectPassword'] = "0";
                    $data['ReferenceIdValue'] = $ReferenceIdValue;
                } else {
                    $data['error_message'] = "Password doest not match";
                }
            }

            $currentDateTime = date('Y-m-d H:i:s');

            $mapperQuestionnaires = new Application_Model_Mapper_Questionnaire();
            $item = $mapperQuestionnaires->get($this->key);
            $item->setSurveyCount($item->getSurveyCount() + 1);
            $mapperQuestionnaires->save($item);

            $itemQ = new Application_Model_QuestionnaireAnswers();
            $mapperQ = new Application_Model_Mapper_QuestionnaireAnswers();
            $mapperQM = new Application_Model_Mapper_QuestionnaireQuestionMap();

            $notificationEmail = '<table style="border:1px solid grey; width: 100%" cellspacing="0"><tbody>';

            foreach ($postData as $v) {
                if (is_array($v)) {
                    $v['ip_address'] = $this->getRealIpAddr();
                    $v['user_agent'] = serialize($this->getBrowser());
                    if (is_array($v['answer'])) {
                        $v['answer'] = serialize($v['answer']);
                    }
                    $questionD = $mapperQM->get((int) $v['question_id']);
                    $notificationEmail .= '<tr><td  style="border-bottom:1px solid grey; padding: 10px;">' . $questionD->getQuestion() . '</td><td  style="border-bottom:1px solid grey; padding: 10px;">' . $v['answer'] . '</td></tr>';
                    $itemQ->setOptions($v);
                    $itemQ->setId(null);

                    $itemQ->setCreated($currentDateTime);
                    $itemQ->setUpdated($currentDateTime);
                    //echo '<pre>'; print_r($itemQ); exit;
                    $mapperQ->save($itemQ, false);
                }
            }

            $notificationEmail .= '</tbody></table>';

            //deleting reference values and temp data
            if (isset($postData['ReferenceIdValue']) && !empty($postData['ReferenceIdValue'])) {
                $sqlForDeleteFromEmailTable = "delete from _user_auto_save where id=" . $postData['ReferenceIdValue'] . "";
                $db->query($sqlForDeleteFromEmailTable);
                $sqlForDeleteFromEmailTable = "delete from questionnaire_answers_temp where referenceid=" . $postData['ReferenceIdValue'] . "";
                $db->query($sqlForDeleteFromEmailTable);
            }

            $question = $this->results;
            //echo "<pre>dd";print_r($question);die;
            $question_name_slug = str_replace(' ', '-', strtolower(trim($question['name'])));
            if ($redirectFlage == 0) {
                // send notification mail
                if (!empty($item->getNotificationEmail())) {
                    $transport = new Zend_Mail_Transport_Sendmail();
                    $mail = new Zend_Mail();
                    //$mail->setFrom('Notification from Tool', trim($item->getNotificationEmail()));
                    $mail->setFrom('Notification from Tool', trim('notification@maynardleigh.co.uk'));
                    $mail->addTo(trim($item->getNotificationEmail()));
                    $mail->setSubject('Notification Email from Questionnaire -' . trim($item->getName()));
                    $mail->setBodyHTML(trim($notificationEmail));
                    $mail->send($transport);
                }
                
                //send mail to front end customer *************************************** start
                
                //get default template Id
                
                //$db = Zend_Db_Table_Abstract::getDefaultAdapter();
                $sqlfortemplateValue = 'select id from `bespoke_template` where defaultflag=1 and type = "single" and questionnairesid='.$question['id'];
                $stmtTemplate = $db->query($sqlfortemplateValue);
                $mainTemplateValue = $stmtTemplate->fetchColumn();
                //echo "<pre>Hello".$sqlfortemplate;print_r($mainTemplateValue);die;
                if ($mainTemplateValue > 0) {
                    $template_id = (int) $mainTemplateValue;
                    $qans_id = (int) $question['id'];
                    $mapperQuestionnaireAnswers = new Application_Model_Mapper_QuestionnaireAnswers();
                    $mapperTemplate = new Application_Model_Mapper_Bespoketemplate();
                    $answer = $mapperQuestionnaireAnswers->get($qans_id);
                    $template = $mapperTemplate->get($template_id);

                    $questionAnswersMap = array();
                    $questionAnswersMap['[[RESPONSE_DATETIME]]'] = date("d-m-Y", strtotime($answer->getCreated()));
                    if ($questions) {
                        foreach ($questions as $key => $question) {
                            $qanswer = $mapperQuestionnaireAnswers->getAllByQuestion($question->getId(), $questionnaire_id, $answer->getCreated());
                            $ans = '';
                            if ($qanswer) {
                                if ($qanswer->question_type == 'radio' || $qanswer->question_type == 'checkbox') {
                                    $ans = implode(",", unserialize($qanswer->answer));
                                } else {
                                    $ans = $qanswer->answer;
                                }
                            }
                            $questionAnswersMap['[[' . $question->getQuestion() . ']]'] = $ans;
                        }
                    }
                    $findArray = array_keys($questionAnswersMap);
                    $replaceArray = array_values($questionAnswersMap);
                    $templateText = str_replace($findArray, $replaceArray, $template->getDescription());

                    $transport = new Zend_Mail_Transport_Sendmail();
                    $mail = new Zend_Mail();
                    $sqlforgetEmailAddressId = 'SELECT id FROM questionnaires_question_map WHERE questionnaires_id=' . $question['id'] . ' and type="response_email"';
                    $stmtEmail = $db->query($sqlforgetEmailAddressId);
                    $EmailTemplateId = $stmtEmail->fetchColumn();
                    //echo $EmailTemplateId."<pre>";print_r($postData);die;
                    if (array_key_exists('question_' . $EmailTemplateId, $postData)) {
                        $emailAddress = $postData['question_' . $EmailTemplateId]['answer'];
                    }
                    if (isset($emailAddress) and ! empty($emailAddress)) {
                        //echo $emailAddress."<pre>";print_r($templateText);die;
                        //$mail->setFrom('Notification from Tool', trim($item->getNotificationEmail()));
                        //pdf = $this->saveaspdf('Hi Please find attachment! ', $answer->getCreated(),$this->item->getName());
                        $pdf = $this->saveaspdf($templateText, 'Test', 'Test_one');
                        $content = file_get_contents($pdf); // e.g. ("attachment/abc.pdf")
                        //echo "<pre>ddddd";print_r($content);die;
                        $attachment = new Zend_Mime_Part($content);
                        $attachment->type = 'application/pdf';
                        $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                        $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                        $attachment->filename = 'questionnaire.pdf'; // name of file
                        $mail->addAttachment($attachment);
                        $mail->setFrom('Notification from Tool', trim('notification@maynardleigh.co.uk'));
                        $mail->addTo(trim($emailAddress));
                        $mail->setSubject('Notification Email from Questionnaire -' . trim($item->getName()));
                        $mail->setBodyHTML(trim($notificationEmail));
                        try {
                            // echo "<pre>";print_r($mail);die;
                            $mail->send($transport);
                        } catch (Exception $e) {
                            //echo "<pre>";print_r($e);die;
                        }
                    }
                }


                //die("Hello".$templateText);
                //send mail to front end customer *************************************** end
                
                
                
                $this->_redirect('/bespoke/thankyou/' . $question_name_slug . '/' . base64_encode(base64_encode($this->key)));
            }

        }

        $CompleteInfo = array();
        $CompleteInfo['questionDetial'] = $mainQuestion[0];

        $sqlForSection = "SELECT id,questionnaires_id,title,sub_title FROM questionnaires_section WHERE questionnaires_id ="  . $mainQuestion[0]['id']. " ORDER BY order_sequence,id";
        $stmtForSection = $db->query($sqlForSection);
        $Sections = $stmtForSection->fetchAll();
        $CompleteInfo['sectiondetail'] = $Sections;
        //echo "<pre>";print_r($CompleteInfo);

        //getting question detail
        $questionArray = array();
        foreach ($Sections as $SinleSection) {
            $sqlforQuestion = 'select id,section_id,question,type,aligment,required,option_value from '
            . 'questionnaires_question_map where section_id= ' . $SinleSection["id"] . ' and questionnaires_id = ' . $this->key . ' order by ordering';
            $stmtForQuestion = $db->query($sqlforQuestion);
            $Questions = $stmtForQuestion->fetchAll();
            //$CompleteInfo['sectiondetail'][$SinleSection['id']] = $Questions;
            $questionArray[$SinleSection["id"]] = $Questions;
        }
        $data['question_and_detail'] = $CompleteInfo;
        $data['questions'] = $questionArray;
        $data['key'] = $this->key;
        $this->view->data = $data;
    }
    public function getFullName($created)
    {
        $first_name = $last_name = '';
        $questionnaire_id = $this->questionnaireId;
        $mapperQuestionnaireAnswers = new Application_Model_Mapper_QuestionnaireAnswers();
        $first_name_question = $this->mapperQuestion->getQuestionByName($questionnaire_id, 'first name');

        if ($first_name_question) {
            $first_name_ans = $mapperQuestionnaireAnswers->getAllByQuestion($first_name_question['id'], $questionnaire_id, $created);
            if ($first_name_ans) {
                $object = new Application_Model_QuestionnaireAnswers($first_name_ans->toArray());
                $first_name = $object->getAnswer();
            }
        }

        $last_name_question = $this->mapperQuestion->getQuestionByName($questionnaire_id, 'last name');

        if ($last_name_question) {
            $last_name_ans = $mapperQuestionnaireAnswers->getAllByQuestion($last_name_question['id'], $questionnaire_id, $created);
            if ($last_name_ans) {
                $object = new Application_Model_QuestionnaireAnswers($last_name_ans->toArray());
                $last_name = $object->getAnswer();
            }
        }
        if ((empty($first_name) && empty($last_name)) || ($last_name == ' --- ' && $first_name == ' --- ')) {
            $first_name = '';
            $last_name = '';
            $last_name_question = $this->mapperQuestion->getQuestionByName($questionnaire_id, 'your full name');
            $last_name_ans = $mapperQuestionnaireAnswers->getAllByQuestion($last_name_question['id'], $questionnaire_id, $created);
            if ($last_name_ans) {
                $object = new Application_Model_QuestionnaireAnswers($last_name_ans->toArray());
                $last_name = $object->getAnswer();
            }
        }
        if (!empty($first_name) || !empty($last_name)) {
            return $first_name . ' ' . $last_name;
        } else {
            return false;
        }
    }
     public function saveaspdf($html = '', $created = '', $QuestionBankName = '', $output = 'save', $upload_path = '')
    {
        $fullPdfPath = '';
        $path = APPLICATION_PATH . '/library/mpdf';
        include_once $path . '/vendor/autoload.php';
        $FrontURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        $baseUrl = Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl();
        $postData = $this->getRequest()->getPost();

        try {
            $header_image = $FrontURL . $baseUrl . '/images/pdf_header.png';
            $footer_image = $FrontURL . $baseUrl . '/images/bg-footer.jpg';

            $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    PUBLIC_PATH . '/fonts/brandon-grotesque',
                ]),
                'fontdata' => $fontData + [
                    'brandon-grotesque' => [
                        'R' => 'Brandon_reg.ttf',
                        'I' => 'Brandon_reg_it.ttf',
                        'L' => 'Brandon_light.ttf',
                    ],
                ],
                'default_font' => 'brandon-grotesque',
                'default_font_size' => 12,
            ]);

            $finalHtml = '';

            if (isset($postData['default_pdf_header_image']) && $postData['default_pdf_header_image'] == 'y') {
                $finalHtml = '<div style="width:100%;padding:4px;height:144px"><svg width="100%" height="0%" viewBox="0 0 800 125">
                <image xlink:href="' . $header_image . '" width="100%" height="124" x="2" y="2" preserveAspectRatio="none" />
                <text x="220" y="65" font-size="30" stroke-width="1" stroke="#fff" fill="#fff"><strong>' . $QuestionBankName . '</strong></text>
                </svg></div>';
            }

            $finalHtml .= '<div style="margin:0px 30px 0px 30px;font-family:brandon-grotesque;clear:both">';
            $finalHtml .= $html;
            $finalHtml .= '<div>';

            $mpdf->AddPageByArray([
                'margin-left' => 0,
                'margin-right' => 0,
                'margin-top' => 0,
                'margin-bottom' => 20,
                'margin-footer' => 3,
            ]);

            $mpdf->SetHTMLFooter('<table width="100%" style="border-top: 1px solid #0b3856;margin:10px; font-size:10px">
                <tr>
                    <td width="70%">Find out more about Maynard Leigh Associates at <a target="new" href="https://www.maynardleigh.com/">www.maynardleigh.com</a></td>
                    <td width="30%" style="text-align: right;"></td>
                </tr>
            </table>');

            $mpdf->WriteHTML(utf8_encode($finalHtml));

            $mpdf->setAutoBottomMargin = 'stretch';

            //echo'<pre>'; print_r($mpdf); exit;
            // Other code
            //$mpdf->Output();

            $file_name_ext = pathinfo($created, PATHINFO_EXTENSION);
            if ($file_name_ext == 'pdf') {
                $pdf_name = $created;
            } else {
                $fileName = 'Test Name';
                if (!empty($created)) {
                    $fullName = 'Test Name';
                    if ($fullName) {
                        $fileName = $fullName;
                    }
                }
                $upload_path = $upload_path ?? APPLICATION_PATH . '/../UserFiles/File/';
                $pdf_name = strtolower(str_replace(' ', '_', trim($fileName))) . '_' . date('YmdHis') . '.pdf';
            }

            $fullPdfPath = $upload_path . $pdf_name;

            if ($output == 'download') {
                $mpdf->Output($pdf_name, \Mpdf\Output\Destination::DOWNLOAD);
                exit;
            } else {
                $mpdf->Output($fullPdfPath, \Mpdf\Output\Destination::FILE);

                return $fullPdfPath;
            }
        } catch (\Mpdf\MpdfException $e) {
            // Note: safer fully qualified exception name used for catch
            // Process the exception, log, print etc.
            echo $e->getMessage();
            exit;
        }
    }
    public function qrcodeAction()
    {
        $this->view->headTitle('Questionnaire');
        $qrvalue = $this->getRequest()->getParam('qrvalue');
        $group_name = $this->getRequest()->getParam('group_name');
        $date = date('m_d_Y', time());
        $this->qrcodeUrl = '/phpqrcode?file_name=key_' . $date . '_' . $this->key . '&qrvalue=' . $qrvalue . '&group_name=' . $group_name;
        $this->_redirect($this->qrcodeUrl);
        //echo $this->qrcodeUrl;die;
    }

    public function questionnairetempAction()
    {
        //$this->key = $this->getRequest()->getParam('key');
        $referenceId = $this->getRequest()->getParam('referenceid');
        if (!$this->key) {$this->key = 0;}
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();
            $itemQ = new Application_Model_QuestionnaireAnswerstemp();
            $mapperQ = new Application_Model_Mapper_QuestionnaireAnswerstemp();
            $mapperQDeleteObj = new Application_Model_Mapper_QuestionnaireAnswerstemp();
            foreach ($postData as $v) {
                if (is_array($v)) {
                    //echo "<pre>";print_r($v);die;
                    $v['ip_address'] = $this->getRealIpAddr();
                    $v['session_id'] = $postData['session_id'];
                    $v['user_agent'] = serialize($this->getBrowser());
                    $v['referenceid'] = $referenceId;
                    if (is_array($v['answer'])) {
                        $v['answer'] = serialize($v['answer']);
                    }
                    $v['referenceid'] = $referenceId;
                    $itemQ->setOptions($v);
                    //before save we have to delete old data
                    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                    $sqlfordelete = "DELETE FROM `questionnaire_answers_temp` WHERE referenceid='" . $referenceId . "' and  question_id = '" . $v['question_id'] . "' and questionnaire_id= '" . $v['questionnaire_id'] . "'";
                    $stmt = $db->query($sqlfordelete);
                    //saveing it
                    $mapperQ->save($itemQ);
                }
            }
            //$this->_redirect('/bespoke/thankyou/key/' . $this->key);
        }
        $this->_helper->layout()->disableLayout();
        die("Done");
    }

    public function thankyouAction()
    {
        $this->view->headTitle('Thank you');
        $savevalue = $this->getRequest()->getParam('message');
        if ($savevalue == 'save') {
            $message = 'Your answers have been saved and we have sent you retrieval instructions to the email address provided.';
            $ThankYouMessage = "DRAFT <br>SAVED";
        } else {
            $message = 'You have successfully submitted your response.';
            $ThankYouMessage = "THANK <br>YOU";
        }
        $data['message'] = $message;
        $data['thankyou'] = $ThankYouMessage;
        $this->view->data = $data;
        $this->view->results = $this->results;
    }

    public function nofoundAction()
    {
        //getting header image
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT id,name,short_description,description,image,header_image,bg_color FROM questionnaires WHERE id =" . (int) $this->key;
        $stmt = $db->query($sql);
        $mainQuestion = $stmt->fetchAll();

        $this->view->headTitle('Not in use');
        $message = 'Sorry this questionnaire is no longer in use. Thanks for your visit.';
        $ThankYouMessage = "THANKS <br> BUT...";
        $data['message'] = $message;
        $data['thankyou'] = $ThankYouMessage;
        $this->view->data = $data;
        $this->view->results = $mainQuestion[0];
    }

    public function emailsaveAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->key = $this->getRequest()->getParam('key');
            $postData = $this->getRequest()->getPost();
            try {
                $smtpServer = 'smtp.gmail.com';
                $username = 'itfosters@gmail.com';
                $password = 'ITFosters@123##';

                $config = array('ssl' => 'tls',
                    'port' => '587',
                    'auth' => 'login',
                    'username' => $username,
                    'password' => $password);

                //$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
                $transport = new Zend_Mail_Transport_Sendmail();
                $mail = new Zend_Mail();

                /*
                $email_from      = trim($postData['email_from']);
                $email_from_name = trim($postData['email_from_name']);
                $email_to        = trim($postData['email_to']);
                $email_subject   = trim($postData['email_subject']);
                $email_body      = trim($postData['email_body']);
                $email_text      = trim($postData['email_text']);
                 */

                $email_from = 'support@maynardleigh.co.uk';
                $email_from_name = 'Support Maynardleigh';
                $email_to = $postData['email_for_send'];
                $email_subject = 'Reference for save Questionnaire ';
                $urlencode = base64_encode($postData['email_for_send']);
                //$publicURL       = 'http://maynard.com/bespoke/questionnaire/key/'.$this->key.'/reference/'.$urlencode;
                $FrontURL     = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
                //$publicURL = 'https://project.itfosters.com/maynardleigh2/bespoke/questionnaire/key/' . $this->key . '/reference/' . $urlencode;
                $publicURL = $FrontURL.'/bespoke/questionnaire/key/' . $this->key . '/reference/' . $urlencode;
                $email_body = '<p>Dear User</p><p>This is reference link for Questionnaire </p><p>Link Is: <a href="' . $publicURL . '" target="_blank">Click here</a> </p><p>Password Is: ' . $postData['create_password'] . ' </p>';
                $email_text = 'Email text ';

                $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                $sqlforsave = "INSERT INTO _user_auto_save (id, password, url,email, created, updated) VALUES (NULL, '" . $postData['create_password'] . "','" . $publicURL . "', '" . $postData['email_for_send'] . "', NULL, NULL);";
                $stmt = $db->query($sqlforsave);

                $valid = true;
                if (empty($email_from) && filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
                    $valid = false;
                } elseif (empty($email_from_name)) {
                    $valid = false;
                } elseif (empty($email_to) && filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
                    $valid = false;
                } elseif (empty($email_subject)) {
                    $valid = false;
                } elseif (empty($email_body)) {
                    $valid = false;
                } elseif (empty($email_text)) {
                    $valid = false;
                }

                if ($valid) {
                    $mail->setFrom(trim($email_from), trim($email_from_name));
                    $mail->addTo(trim($email_to));
                    $mail->setSubject(trim($email_subject));
                    $mail->setBodyHTML(trim($email_body));
                    $mail->send($transport);
                    $this->_helper->FlashMessenger('Response sent');

                } else {
                    $this->_helper->FlashMessenger(array('error' => 'There is an error while validation.'));
                }

            } catch (\Exception $e) {
                // Note: safer fully qualified exception name used for catch
                // Process the exception, log, print etc.
                echo $e->getMessage();exit;
                $this->_helper->FlashMessenger(array('error' => 'There is an error while sending response.'));
            }
            echo $db->lastInsertId();die;
        }
    }

    private function sendMail($id, $template_file, $subject)
    {

        $mail = new Essential_Mail();

        $item = $this->mapper->get($id);

        $data = array('fname' => $item->getFname(),
            'email' => $item->getEmail(),
            'unique_key' => $item->getUniqueKey(),
            'company_id' => $this->team->getCompanyId(),
        );
        $mail->send($data, $template_file, $subject);
    }

    private function finishReport()
    {

        //setting profile as finished
        $this->team->setFinished('1');
        $this->team_mapper->save($this->team);

        //generating charts for profile
        $report = new Essential_FinishReport();
        $report->generateCharts($this->mapper, $this->results->getTeamId());
    }

    private function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {$version = "?";}

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern,
        );
    }

}
