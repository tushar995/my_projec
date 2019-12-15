<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo 'LIVE WIRE'; ?> | Verify Email</title>
    
</head>
<body style="font-family: 'Source Sans Pro', sans-serif; padding:0; margin:0;">
    <table style="max-width: 750px; margin: 0px auto; width: 100% ! important; background: #F3F3F3; padding:30px 30px 30px 30px;" width="100% !important" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: center; background: #ffffff;">
                <table width="100%" border="0" cellpadding="30" cellspacing="0">    
                    <tr>
                        <td>
                            <img style="max-width: 125px; width: 100%;padding: 10px;" src="<?php echo base_url().ADMIN_THEME; ?>images/logo/logo.png">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: center;">
                <table width="100%" border="0" cellpadding="30" cellspacing="0" bgcolor="#fff">
                    <tr>
                        <td>
                            <p style="text-align: left; color: #333; font-size: 16px; line-height: 28px;">Hello <?php echo ucfirst($full_name);?>,</p>
                            <p style="text-align: left; color: #333; font-size: 16px; line-height: 28px;">Welcome to Live Wire!</p>

                            <p style="text-align: left;color: #333; font-size: 16px; line-height: 28px;">Please verify your email address by clicking the link below:</p>
                             <a href="<?php echo $link;?>" style=" background-color: #309f34;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;margin: 4px 2px;">Click here to verify your email address</a>

                            <p style="text-align: left;color: #333; font-size: 16px; line-height: 28px;">Thanks,<br><?php echo 'LIVE WIRE'; ?> team</p>  
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#fff">
                     <tr>
                        <td style="padding: 10px;background: #23c466;color: #fff;">Copyright &copy; <?php echo date('Y') ?> LIVE WIRE</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>