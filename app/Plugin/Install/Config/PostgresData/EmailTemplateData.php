<?php
/**
 *
 * @package		Crowdfunding
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-07-25
 *
 */
class EmailTemplateData {

	public $table = 'email_templates';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2009-02-20 10:24:49',
			'modified' => '2013-05-27 06:30:26',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Forgot Password',
			'description' => 'we will send this mail, when user submit the forgot password form.',
			'subject' => 'Forgot password',
			'email_text_content' => 'Dear ##USERNAME##,  \\n\\nA password reset request has been made for your user account at ##SITE_NAME##.  If you made this request, please click on the following link:  ##RESET_URL##  \\nIf you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##  \\n\\nThanks, \\n##SITE_NAME## ##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
	<table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A password reset request has been made for your user account at ##SITE_NAME##.  If you made this request, please click on the following link:  ##RESET_URL##
</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##
</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'USERNAME, RESET_URL, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '2',
			'created' => '2009-02-20 10:15:57',
			'modified' => '2013-05-27 06:39:46',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Activation Request',
			'description' => 'we will send this mail, when user registering an account he/she will get an activation request.',
			'subject' => 'Please activate your ##SITE_NAME## account',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\nYour account has been created. \\nPlease visit the following URL to activate your account.\\n##ACTIVATION_URL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been created.</p></td>
                </tr>
                <tr>
                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please visit the following URL to activate your account.</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##ACTIVATION_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME, USERNAME, ACTIVATION_URL, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '3',
			'created' => '2009-02-20 10:15:19',
			'modified' => '2013-05-27 06:43:42',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New User Join',
			'description' => 'we will send this mail to admin, when a new user registered in the site. For this you have to enable \"admin mail after register\" in the settings page.',
			'subject' => '[##SITE_NAME##] New user joined',
			'email_text_content' => 'Hi,\\n\\nA new user named \"##USERNAME##\" has joined in ##SITE_NAME##.\\n\\nUsername: ##USERNAME##\\nEmail: ##USEREMAIL##\\nSignup IP: ##SIGNUPIP##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A new user named \"##USERNAME##\" has joined in ##SITE_NAME##.</p></td>
                </tr>
                <tr>
                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Username: ##USERNAME##</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Email: ##USEREMAIL##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Signup IP: ##SIGNUPIP##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL,USEREMAIL,SIGNUPIP',
			'is_html' => ''
		),
		array(
			'id' => '22',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-05-27 06:49:09',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Change Status Alert',
			'description' => 'we will send this when a project status change.',
			'subject' => '[##SITE_NAME##][##PROJECT##] Status: ##PREVIOUS_STATUS## -> ##CURRENT_STATUS##',
			'email_text_content' => 'Hi,\\n\\nStatus was changed for project \"##PROJECT##\".\\n\\nStatus: ##PREVIOUS_STATUS## -> ##CURRENT_STATUS##\\n\\nPlease click the following link to view the project,\\n##PROJECT_URL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Status was changed for project \"##PROJECT##\".</p></td>
                </tr>
                <tr>
                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Status: ##PREVIOUS_STATUS## -> ##CURRENT_STATUS##</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Please click the following link to view the project,</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##PROJECT_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'PREVIOUS_STATUS,CURRENT_STATUS,PROJECT,PROJECT_URL,SITE_NAME,SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '4',
			'created' => '2009-03-02 00:00:00',
			'modified' => '2013-05-27 06:51:57',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Add',
			'description' => 'we will send this mail to user, when a admin add a new user.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\n##SITE_NAME## team added you as a user in ##SITE_NAME##.\\n\\nYour account details.\\n##LOGINLABEL##:##USEDTOLOGIN##\\nPassword:##PASSWORD##\\n\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team added you as a user in ##SITE_NAME##.




</p></td>
                </tr>
                <tr>
                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account details.</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Please ##LOGINLABEL##:##USEDTOLOGIN##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Password:##PASSWORD##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME, USERNAME, PASSWORD, LOGINLABEL, USEDTOLOGIN, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '5',
			'created' => '2009-05-22 16:51:14',
			'modified' => '2013-05-27 06:53:02',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Welcome Email',
			'description' => 'we will send this mail, when user register in this site and get activate.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\nWe wish to say a quick hello and thanks for registering at ##SITE_NAME##.\\n\\nIf you did not request this account and feel this is an error, please\\ncontact us at ##CONTACT_MAIL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">We wish to say a quick hello and thanks for registering at ##SITE_NAME##.</p></td>
                </tr>
                <tr>
                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this account and feel this is an error, please
contact us at ##CONTACT_MAIL##.</p></td>
                </tr>

              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME, SITE_URL, USERNAME, SUPPORT_EMAIL',
			'is_html' => ''
		),
		array(
			'id' => '7',
			'created' => '2009-05-22 16:45:38',
			'modified' => '2010-12-27 13:18:47',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Active ',
			'description' => 'We will send this mail to user, when user active
by administator.',
			'subject' => 'Your ##SITE_NAME## account has been activated',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\nYour account has been activated.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been activated.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '8',
			'created' => '2009-05-22 16:48:38',
			'modified' => '2010-12-27 13:19:06',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Deactivate',
			'description' => 'We will send this mail to user, when user deactive by administator.',
			'subject' => 'Your ##SITE_NAME## account has been deactivated',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\nYour ##SITE_NAME## account has been deactivated.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been deactivated.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '9',
			'created' => '2009-05-22 16:50:25',
			'modified' => '2013-05-27 08:20:21',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Delete',
			'description' => 'We will send this mail to user, when user delete by administrator.',
			'subject' => 'Your ##SITE_NAME## account has been removed',
			'email_text_content' => 'Dear ##USERNAME##,\\n\\nYour ##SITE_NAME## account has been removed.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your ##SITE_NAME## account has been removed.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '10',
			'created' => '2009-07-07 15:47:09',
			'modified' => '2009-09-30 10:10:42',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin Change Password',
			'description' => 'we will send this mail to user, when admin change user\'s password.',
			'subject' => 'Password changed',
			'email_text_content' => 'Hi ##USERNAME##,

Admin reset your password for your  ##SITE_NAME## account.

Your new password: ##PASSWORD##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Admin Change Password</title>
<style type=\"text/css\">
 @import url(http://fonts.googleapis.com/css?family=Open+Sans);
</style>
<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
</head>

<body>
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Admin reset your password for your  ##SITE_NAME## account.</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your new password: ##PASSWORD##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
',
			'email_variables' => 'SITE_NAME,PASSWORD,USERNAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '11',
			'created' => '2009-10-14 18:31:14',
			'modified' => '2013-05-25 14:45:48',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contact Us',
			'description' => 'We will send this mail to admin, when user submit any contact form.',
			'subject' => '[##SITE_NAME##] ##SUBJECT##',
			'email_text_content' => '##MESSAGE##\\n\\n----------------------------------------------------\\nTelephone    : ##TELEPHONE##\\nIP           : ##IP##, ##SITE_ADDR##\\nWhois        : http://whois.sc/##IP##\\nURL          : ##FROM_URL##\\n----------------------------------------------------\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##MESSAGE##</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Telephone    : ##TELEPHONE##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">IP           : ##IP##, ##SITE_ADDR##</p></td>
                </tr><tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Whois        : http://whois.sc/##IP##</p></td>
                </tr><tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL          : ##FROM_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'FROM_URL, IP, TELEPHONE, MESSAGE, SITE_NAME, SUBJECT, FROM_EMAIL, LAST_NAME, FIRST_NAME',
			'is_html' => ''
		),
		array(
			'id' => '12',
			'created' => '2009-10-14 19:20:59',
			'modified' => '2010-12-27 13:21:22',
			'from' => '##CONTACT_FROM_EMAIL##',
			'reply_to' => '',
			'name' => 'Contact Us Auto Reply',
			'description' => 'we will send this mail ti user, when user submit the contact us form.',
			'subject' => 'RE: ##SUBJECT##',
			'email_text_content' => 'Dear ##FIRST_NAME####LAST_NAME##,

Thanks for contacting us. We\'ll get back to you shortly.

Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##

------ On ##POST_DATE## you wrote from ##IP## -----

##MESSAGE##
',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Thanks for contacting us. We\'ll get back to you shortly.</p>

            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##
</p></td>
                </tr>


              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'MESSAGE, POST_DATE, SITE_NAME, CONTACT_URL, FIRST_NAME, LAST_NAME, SUBJECT, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '18',
			'created' => '2010-10-08 14:21:30',
			'modified' => '2010-12-28 06:20:16',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Update Alert',
			'description' => 'This is sent to followers when an update is added to a project.',
			'subject' => '[##PROJECT##] Project updates posted',
			'email_text_content' => 'Dear ##USERNAME##,

A new update \"##BLOG_TITLE##\" has been posted to the project ##PROJECT##.

Please click the following link to view the update,
##BLOG_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A new update \"##BLOG_TITLE##\" has been posted to the project ##PROJECT##.</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the update,</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##BLOG_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME, PROJECT, SITE_NAME, SITE_URL,BLOG_TITLE,BLOG_URL',
			'is_html' => ''
		),
		array(
			'id' => '19',
			'created' => '2010-10-08 14:25:32',
			'modified' => '2010-12-28 06:31:34',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Update Comment Alert',
			'description' => 'This is sent to follower when a comment is added to update on his project.',
			'subject' => '[##PROJECT##] Comment added to project update',
			'email_text_content' => 'Dear ##USERNAME##,

##COMMENTED_USER## has commented on update \"##BLOG_TITLE##\" in the project ##PROJECT##.

Please click the following link to view the comment,
##BLOG_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##</p>,
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##COMMENTED_USER## has commented on update \"##BLOG_TITLE##\" in the project ##PROJECT##.   </p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the comment,</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##BLOG_URL##</p></td>
                </tr>


              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME, USER, PROJECT, SITE_NAME, SITE_URL,BLOG_TITLE,BLOG_URL',
			'is_html' => ''
		),
		array(
			'id' => '20',
			'created' => '2010-10-08 15:02:07',
			'modified' => '2010-12-27 13:25:21',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Comment Alert',
			'description' => 'This is sent to followers when a new comment is added to a project.',
			'subject' => '[##PROJECT##] Comment added to project',
			'email_text_content' => 'Dear ##USERNAME##,

##COMMENTED_USER## has commented on the project ##PROJECT##.

Please click the following link to view the comment,
##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##COMMENTED_USER## has commented on the project ##PROJECT##.</p>

            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the comment,
##PROJECT_URL##
</p></td>
                </tr>


              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME, COMMENTED_USER,  PROJECT, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '21',
			'created' => '2010-11-12 19:54:29',
			'modified' => '2010-12-28 04:48:43',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Fund Alert',
			'description' => 'When new fund was made, an internal message will be sent to the followers of the project.',
			'subject' => '[##SITE_NAME##][##PROJECT##] New fund has been received',
			'email_text_content' => 'Dear ##USERNAME##,

New fund has been received for project ##PROJECT##.
Backer: ##BACKER##
Amount: ##AMOUNT##

Please click the following link to view the project,
##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL## ',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">New fund has been received for project ##PROJECT##.</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Backer: ##BACKER##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Amount: ##AMOUNT##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the project,##PROJECT_URL##</p></td>
                </tr>
	</tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME,BACKER,PROJECT,PROJECT_URL:,AMOUNT',
			'is_html' => ''
		),
		array(
			'id' => '28',
			'created' => '2010-12-06 18:20:07',
			'modified' => '2010-12-27 13:26:38',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Message',
			'description' => 'we will send this mail, when a user get new message',
			'subject' => '##USERNAME## sent you a message on ##SITE_NAME##',
			'email_text_content' => 'Dear ##OTHERUSERNAME##,\\n\\n##USERNAME## sent you a message.\\n\\nTo reply to this message, follow the link below:\\n##MESSAGE_LINK##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##OTHERUSERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##USERNAME## sent you a message.</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To reply to this message, follow the link below:##MESSAGE_LINK##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME,MESSAGE,MESSAGE_LINK,SITE_NAME,OTHERUSERNAME,SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '26',
			'created' => '2010-12-06 18:20:07',
			'modified' => '2010-12-27 11:28:51',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project refund notification',
			'description' => 'we will send this mail, when a refund to backer',
			'subject' => '[##PROJECT_NAME##] Project amount  authorization  canceled',
			'email_text_content' => 'Dear ##USERNAME##,

Your pledged amount ##AMOUNT## for the project \"##PROJECT_NAME##\" has been refunded and credited to your wallet.

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your pledged amount ##AMOUNT## for the project \"##PROJECT_NAME##\" has been refunded and credited to your wallet.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'PROJECT_NAME,SITE_NAME,SITE_URL,USER_NAME',
			'is_html' => ''
		),
		array(
			'id' => '24',
			'created' => '2010-12-06 18:20:07',
			'modified' => '2010-12-27 13:09:43',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Fund Canceled Alert',
			'description' => 'we will send this mail, when canceled a project fund',
			'subject' => '[##PROJECT##] Project fund canceled',
			'email_text_content' => 'Dear ##USERNAME##,

##BACKER## fund for the "##PROJECT##" project was canceled.

Please click the following link to view the project,
##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##BACKER## fund for the "##PROJECT##" project was canceled.</p></td>
                </tr>
	<tr>
	<td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the project,##PROJECT_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'PROJECTE,SITE_NAME,SITE_URL,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '29',
			'created' => '2010-12-14 17:50:54',
			'modified' => '2010-12-27 13:28:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Project',
			'description' => 'we will send this when a new projecct is added.',
			'subject' => 'New project added - ##PROJECT_NAME##',
			'email_text_content' => 'Dear Admin,\\n\\nNew project added.\\n\\nProject Name: ##PROJECT_NAME##\\nCategory: ##CATEGORY##\\nCreated by: ##USERNAME##\\nURL: ##PROJECT_URL##\\nNeeded Amount: ##AMOUNT##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Admin,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">New project added.</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Project Name: ##PROJECT_NAME##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Category: ##CATEGORY##</p></td>
                </tr><tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Created by: ##USERNAME##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL: ##PROJECT_URL##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Needed Amount: ##AMOUNT##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'PROJECT_NAME,CATEGORY,USERNAME,PROJECT_URL,AMOUNT,SITE_NAME,SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '25',
			'created' => '2010-10-08 15:02:07',
			'modified' => '2010-12-27 13:25:21',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Follower Alert',
			'description' => 'This is sent to followers when a new follower for project.',
			'subject' => '[##PROJECT##] New follower for project',
			'email_text_content' => 'Dear ##USERNAME##,

##FOLLOWED_USER## has followed the project ##PROJECT##.

Please click the following link to view the project,
##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##FOLLOWED_USER## has followed the project ##PROJECT##.</p></td>
                </tr>
	<tr>
	<td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the project,##PROJECT_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'USERNAME, PROJECT, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '6',
			'created' => '2010-12-14 17:50:54',
			'modified' => '2012-06-13 07:29:38',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Membership Fee',
			'description' => 'Pay Membership Fee',
			'subject' => '[##SITE_NAME##] Pay Membership Fee',
			'email_text_content' => 'Dear ##USERNAME##,
       You have successfully registered with our site ##SITE_NAME##. Please pay your membership fee for activate your account.

URL: ##MEMBERSHIP_URL##

Note: If you paid membership fee then please ignore this email.Thanks for sign up with us.

Thanks,
##SITE_NAME##
##SITE_URL## ',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">You have successfully registered with our site ##SITE_NAME##. Please pay your membership fee for activate your account.
	  </p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL: ##MEMBERSHIP_URL## </p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Note: If you paid membership fee then please ignore this email.Thanks for sign up with us. </p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'USERNAME,MEMBERSHIP_URL,SITE_NAME,SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '23',
			'created' => '2010-10-08 14:35:52',
			'modified' => '2010-12-28 06:27:54',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Voting Alert',
			'description' => 'This is sent to followers when rating is added to a project.',
			'subject' => '[##PROJECT##] Voting added to project',
			'email_text_content' => 'Dear ##USERNAME##,

##VOTED_USER## has voted on the project ##PROJECT##.

Please click the following link to view the project,
##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##VOTED_USER## has voted on the project ##PROJECT##.</p></td>
                </tr>
	<tr>
	<td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the project,##PROJECT_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'USERNAME, PROJECT, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '13',
			'created' => '2012-07-27 15:17:04',
			'modified' => '2012-07-27 15:17:07',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Forgot Password',
			'description' => 'we will send this mail, when user submit the forgot password form.',
			'subject' => 'Forgot password request failed',
			'email_text_content' => 'Hi there,

You (or someone else) entered this email address when trying to change the password of an ##user_email## account.

However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account.

If you are not an ##SITE_NAME## customer, please ignore this email. If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##.

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi there,</p>

            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">You (or someone else) entered this email address when trying to change the password of an ##user_email## account.</p></td>
                </tr>
	 <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">
However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account.</p></td>
	</tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you are not an ##SITE_NAME## customer, please ignore this email. If you did not request this action and feel this is an error, please contact us </p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '14',
			'created' => '2012-07-30 10:30:44',
			'modified' => '2012-07-30 10:30:48',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Password changed',
			'description' => 'we will send this mail, when user changed his password.',
			'subject' => 'Password changed',
			'email_text_content' => 'Dear ##USERNAME##,

Successfully you have changed your password at ##SITE_NAME##. If you did not request this action , please contact us ##SUPPORT_EMAIL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Successfully you have changed your password at ##SITE_NAME##. If you did not request this action , please contact us ##SUPPORT_EMAIL## </p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'USERNAME, RESET_URL, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '15',
			'created' => '2012-07-30 10:30:44',
			'modified' => '2012-07-30 10:30:44',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Social User',
			'description' => 'we will send this mail, when user submit the forgot password form and the user users social network websites like twitter, facebook to register.',
			'subject' => 'Forgot password request failed',
			'email_text_content' => 'Hi ##USERNAME##,

Your forgot password request was failed because you have registered via ##OTHER_SITE## site.

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your forgot password request was failed because you have registered via ##OTHER_SITE## site.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL,OTHER_SITE',
			'is_html' => ''
		),
		array(
			'id' => '30',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite User',
			'description' => 'we will send this mail to invite user for private beta.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear Subscriber,\\n\\n##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '16',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Launch mail',
			'description' => 'we will send this mail to inform user that the site launched.',
			'subject' => ' ##SITE_NAME## Launched',
			'email_text_content' => 'Dear Subscriber,

##SITE_NAME##  Launched
##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...
##INVITE_LINK##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  Launched ##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '17',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Private Beta mail',
			'description' => 'we will send this mail to inform user that the site move to Private Beta.',
			'subject' => '##SITE_NAME## moved to Private Beta',
			'email_text_content' => 'Dear Subscriber,\\n\\n##SITE_NAME##  moved to Private Beta, Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  moved to Private Beta, Click the below link to join us...##INVITE_LINK##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  moved to Private Beta, Click the below link to join us...##INVITE_LINK##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '32',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Follow Email',
			'description' => 'we will send this mail to users, when a user followed by them add a project or funded for a project or followed a project',
			'subject' => '##FOLLOWED_USER## ##ACTION## the project ##PROJECT_NAME##',
			'email_text_content' => 'Hi ##USER##,

##FOLLOWED_USER## has ##ACTION## the  project ##PROJECT_NAME##.

Please click the following link to view the project
##PROJECT##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USER##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##FOLLOWED_USER## has ##ACTION## the  project ##PROJECT_NAME##.</p></td>
                </tr>
	 <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click the following link to view the project ##PROJECT##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'FOLLOWED_USER, ACTTION, PROJECT, USER',
			'is_html' => ''
		),
		array(
			'id' => '31',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite New User',
			'description' => 'we will send this mail to invite user by other user',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear ##USER_NAME##,

##OTHER_USER_NAME## has invited you to the site ##SITE_NAME## (##INVITE_LINK##)

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##OTHER_USER_NAME## has invited you to the site ##SITE_NAME## (##INVITE_LINK##)</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>
',
			'email_variables' => '##USER_NAME##,##OTHER_USER_NAME##, ##SITE_NAME##,##SITE_URL##',
			'is_html' => ''
		),
		array(
			'id' => '33',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite Friend',
			'description' => 'we will send this mail to invite friend for private beta.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_text_content' => 'Dear Subscriber,\\n\\nYour friend ##USER_NAME## has invited you to join ##SITE_NAME##. Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your friend ##USER_NAME## has invited you to join ##SITE_NAME##. Click the below link to join us...##INVITE_LINK##</p></td>
                </tr>
	 <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please Invite Code: ##INVITE_CODE##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '34',
			'created' => '2013-04-05 14:58:07',
			'modified' => '2013-04-05 14:58:09',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Repayment Notification',
			'description' => 'we will send this mail to remind repayment date.',
			'subject' => '[##SITE_NAME##] Repayment Notification',
			'email_text_content' => 'Hi ##USERNAME##,

 Your payment due date for ##PROJECT## is on ##DATE##.

Amount: ##AMOUNT##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>
        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your payment due date for ##PROJECT## is on ##DATE##.</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Amount: ##AMOUNT##</p></td>
                </tr>


              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL,AMOUNT,DATE',
			'is_html' => ''
		),
		array(
			'id' => '35',
			'created' => '2013-04-05 14:58:07',
			'modified' => '2013-04-05 14:58:09',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Late Repayment Notification',
			'description' => 'we will send this mail to remind late repayment date.',
			'subject' => '[##SITE_NAME##] Late Repayment Notification',
			'email_text_content' => 'Hi ##USERNAME##,

 Your payment due date for ##PROJECT## is on ##DATE## is missed. Late payment fee will be charged. Please make payment.

Amount: ##AMOUNT##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your payment due date for ##PROJECT## is on ##DATE## is missed. Late payment fee will be charged. </p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> Please make payment.Amount: ##AMOUNT##</p></td>
                </tr>


              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div> ',
			'email_variables' => 'SITE_NAME,USERNAME, SITE_URL,AMOUNT,DATE',
			'is_html' => ''
		),
		array(
			'id' => '36',
			'created' => '2013-04-05 14:58:07',
			'modified' => '2013-04-05 14:58:09',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Edit',
			'description' => 'we will send this mail\\rinto user, when admin edit user\'s profile.',
			'subject' => '[##SITE_NAME##] Profile updated',
			'email_text_content' => 'Hi ##USERNAME##,

Admin updated your profile in ##SITE_NAME## account.

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Admin updated your profile in ##SITE_NAME## account.</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME,EMAIL,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '37',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Prelaunch subscription email confirmation',
			'description' => 'Email confirmation for pre lanuch mode subscription',
			'subject' => 'Email Confirmation',
			'email_text_content' => 'Hi,

Your subscription made successfully. You need to do one more step to confirm your email address. This confirmation is recommended to receive further valuable email from us.
Please visit the following URL to confirm your email
##VERIFICATION_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your subscription made successfully. You need to do one more step to confirm your email address. This confirmation is recommended to receive further valuable email from us.</p></td>
                </tr>
	 <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please visit the following URL to confirm your email ##VERIFICATION_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'SITE_NAME, VERIFICATION_URL, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '38',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Project Rejected',
			'description' => 'We will send this mail to user, when admin reject user project.',
			'subject' => 'Project Rejected',
			'email_text_content' => 'Dear ##USERNAME##,

Your ##PROJECT_NAME## rejected by admin. Please check and update your project and resubmit it to admin approve.

Project Name: ##PROJECT_NAME##
URL: ##PROJECT_URL##

Thanks,
##SITE_NAME##
##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />
<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;\">
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #30BCEF;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>
      </tr>
    </tbody>
  </table>
  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);
background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">
<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">
<tbody>
<tr>
<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/crowdfunding.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>
<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>
<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>
</tr>
</tbody>
</table>
</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">
    <table style=\"background-color: #ffffff;\" width=\"100%\">
      <tbody>

        <tr>
          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>
            <table border=\"0\" width=\"100%\">
              <tbody>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your project rejected by admin. Please check and update your project and resubmit it to admin approve.</p></td>
                </tr>
                <tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Project Name: ##PROJECT_NAME##</p></td>
                </tr>
	<tr>
                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL: ##PROJECT_URL##</p></td>
                </tr>
              </tbody>
            </table>
            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>
        </tr>
        <tr>
          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">
              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #30BCEF;\">Thanks,</h4>
              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #30BCEF;\" title=\"##SITE_NAME## - Collective Buying Power\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_URL##</a></h5>
            </div></td>
        </tr>
      </tbody>
    </table>
    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">
      <tbody>
        <tr>
          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #30BCEF;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">
    <tbody>
      <tr>
        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #30BCEF;\" title=\"##SITE_NAME##\" href=\"##SITE_LINK##\" target=\"_blank\">##SITE_NAME##</a></p></td>
      </tr>
    </tbody>
  </table>
</div>',
			'email_variables' => 'PROJECT_NAME,USERNAME,PROJECT_URL,SITE_NAME,SITE_URL',
			'is_html' => ''
		),
	);

}
