<?php

if ($informORnot==1 AND @$_POST['chooseAction1'] != 4) {

//echo "Post:";


    if (@$_POST['active']){
        $emails = @$_POST['email'];


        $informId = @$_POST['active'];

        foreach($informId as $key => $value){

            if(!empty($emails[$value])){


                $To = sanitize_text_field($emails[$value]);

                if (is_email($To)) {

                    $imageRow = $wpdb->get_row("SELECT * FROM $tablename WHERE id='$value' && Active='1' && Informed='0'");
                    if(!empty($imageRow)){

                        $checkIfInformed = $imageRow->Informed;
                        $post_title = $imageRow->NamePic;

                        if(!empty($imageRow)){

                            if($urlCheck==1 and $url==true){

                                // $codedPictureId = ($value+8)*2+100000; // Verschl�sselte ID ermitteln. Gecachte Sites sind mit verschl�sselter ID gespeichert.
                                //  $url1 = $url."picture_id=$codedPictureId#cg-begin";

                                $url1 = $url."#!gallery/$GalleryID/image/$value/$post_title";
                                $replacePosUrl = '$url$';

                                $Msg = str_ireplace($replacePosUrl, $url1, $contentMail);

                            }


                            /*                                    $headers = '';
                                                                require_once(dirname(__FILE__)."/class-inform-user.php");
                                                                @$headers .= "Reply-To: ". @strip_tags(@$Reply) . "\r\n";
                                                                $headers .= "CC: $cc\r\n";
                                                                $headers .= "BCC: $bcc\r\n";
                                                                $headers .= "MIME-Version: 1.0\r\n";
                                                                $headers .= "Content-Type: text/html; charset=utf-8\r\n";*/


                            $headers = array();
                            $headers[] = "From: $Admin <". strip_tags(@$Reply) . ">\r\n";
                            $headers[] = "Reply-To: ". @strip_tags(@$Reply) . "\r\n";


                            if(strpos($cc,';')){
                                $cc = explode(';',$cc);
                                foreach($cc as $ccValue){
                                    $ccValue = trim($ccValue);
                                    $headers[] = "CC: $ccValue\r\n";
                                }
                            }
                            else{
                                $headers[] = "CC: $cc\r\n";
                            }

                            if(strpos($bcc,';')){
                                $bcc = explode(';',$bcc);
                                foreach($bcc as $bccValue){
                                    $bccValue = trim($bccValue);
                                    $headers[] = "BCC: $bccValue\r\n";
                                }
                            }
                            else{
                                $headers[] = "BCC: $bcc\r\n";
                            }


                            $headers[] = "MIME-Version: 1.0";
                            $headers[] = "Content-Type: text/html; charset=utf-8";


                            global $cgMailAction;
                            global $cgMailGalleryId;
                            $cgMailAction = "Image activation e-mail backend";
                            $cgMailGalleryId = $GalleryID;
                            add_action( 'wp_mail_failed', 'cg_on_wp_mail_error', 10, 1 );

                            wp_mail($To, $Subject, $Msg, $headers);

                            $wpdb->update(
                                "$tablename",
                                array('Informed' => '1'),
                                array('id' => $value),
                                array('%d'),
                                array('%d')
                            );

                        }

                    }


                }


            }

        }

    }

}
