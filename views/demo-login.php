<div style='position: absolute;
            width: 90%;
            margin-top: -10px;
            margin-left: 4%;
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            color: #303030;
            padding: 4px; 
            border: 1px solid #d8d8d8; 
            text-align: center;
            box-shadow: 2px 2px 4px #808080;'>
<span style='font-size: 16px; font-weight: 600;'>Welcome to the Client Portal Demo!</span>
    <table style='margin: 5px auto;'>
        <thead>
        <th style='vertical-align: middle; border: 1px solid #d4d4d4'>User Type</th>
        <th style='vertical-align: middle; border: 1px solid #d4d4d4'>Username</th>
        <th style='vertical-align: middle; border: 1px solid #d4d4d4'>Password</th>
        </thead>
        <tr>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: right'>
                <strong>Staff Login:</strong>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_STAFF_EMAIL')){
                        echo constant('DEMO_STAFF_EMAIL'); 
                    }?>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_STAFF_PASS')){
                        echo constant('DEMO_STAFF_PASS'); 
                    }?>
            </td>
        </tr>
        <tr>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: right'>
                <strong>Client Login:</strong>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_CLIENT_EMAIL')){
                        echo constant('DEMO_CLIENT_EMAIL'); 
                    }?>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_CLIENT_PASS')){
                        echo constant('DEMO_CLIENT_PASS'); 
                    }?>
            </td>
        </tr>
        <tr>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: right'>
                <strong>Admin Login:</strong>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_ADMIN_EMAIL')){
                        echo constant('DEMO_ADMIN_EMAIL'); 
                    }?>
            </td>
            <td style='vertical-align: middle; border: 1px solid #d4d4d4; padding: 4px; text-align: center'>
                <?php 
                    if(defined('DEMO_ADMIN_PASS')){
                        echo constant('DEMO_ADMIN_PASS'); 
                    }?>
            </td>
        </tr>
    </table>
Mail notifications are disabled for this demo. No email info is set.<br>
Be sure to see the <a href="README.html">Documentation</a> for more information.
</div>
