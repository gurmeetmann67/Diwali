<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HTML5 AJAX Contact Form</title>
    <link href="https://cdn.rawgit.com/gurmeetmann67/Diwali/d8a02719/style.css" media="screen" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/gurmeetmann67/Diwali/984013ae/get_directions.jpg"></script>

    <!--[if lt IE 9]>
    <link href="https://cdn.rawgit.com/gurmeetmann67/Diwali/d8a02719/ie.css" media="screen" rel="stylesheet" type="text/css"/>
    <![endif]-->
</head>
<body>

<?php
/**
 * Created by 23rd and Walnut.
 * www.23andwalnut.com
 * User: Saleem El-Amin
 * Date: Aug 29, 2010
 * Time: 1:32:54 PM
 */


/** CONFIGURATION OPTIONS
 * $email_address = The email address that all form submissions will be sent to
 * $company_address = The destination address that will be used in the contact form */

$email_address = 'gurmeetmann67@gmail.com';
$company_address = 'Full Ver PC Game';



/** DO NOT EDIT ANYTHING BELOW THIS LINE UNLESS YOU ARE COMFORTABLE WITH PHP */

echo "<script>var companyAddress = '".$company_address."';</script>";

$field_rules = array(
    'name' => 'required',
    'email' => 'required|valid_email',
    'phone' => '',
    'contact_reason' => 'required',
    'message' => 'required'
);


$error_messages = array(
    'required' => 'This field is required',
    'valid_email' => 'Please enter a valid email address'
);


$error_list = '';


$fields = $_POST;



if (!empty($fields))
{
    //Validate each of the fields
    foreach ($field_rules as $field => $rules)
    {
        $rules = explode('|', $rules);

        foreach ($rules as $rule)
        {
            $result = null;

            if (isset($fields[$field]))
            {
                if (!empty($rule))
                    $result = $rule($fields[$field]);

                if ($result === false)
                {
                    $field_name = ucwords(implode(' ', explode('_', $field)));

                    $error_list .= "<div class='error'>$field_name: " . $error_messages[$rule] . "</div>";
                }
            }
        }
    }

    if (empty($error_list))
    {
        $subject = '[Contact Form] New message from ' . $fields['name'] . '.';

        $content = $fields['name'] . " sent you a message from your contact form:\r\n\n";
        $content .= "-------\n" . $fields['message'] . "\r\n\n";
        $content .= "Contact Reason: " . $fields['contact_reason']
                . " \n\nEmail: " . $fields['email']
                . " \n\nPhone: " . $fields['phone'] . " \n\n";

        if (mail($email_address, $subject, $content, "From: " . $fields['email'] . "\r\nReply-To: " . $fields['email'] . "\r\nReturn-Path: " . $fields['email'] . "\r\n"))
        {

            echo "<h2 class='success'>Message Sent</h2>";
            echo "<br/><p class='success'>Thank you <strong>" . $fields['name'] . "</strong>, your message has been submitted and someone will contact you shortly.</p>";
        }
        else
        {

            echo 'ERROR!';
        }
    }
}

function required($str, $val = false)
{

    if (!is_array($str))
    {
        $str = trim($str);
        return ($str == '') ? false : true;
    }
    else
    {
        return (!empty($str));
    }
}

function valid_email($str)
{
    return (!preg_match("/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD", $str)) ? false : true;
}

?>
<div class="wrapper clearfix">

    <div id="contact-wrapper" class="clearfix">

        <div class="form-wrapper clearfix">

            <h2>Contact Us</h2>

            <div class="message">
            <?php echo !empty($error_list) ? $error_list : ''; ?>
            </div>

            <form id="contact-form" action="" method="post" novalidate>

                <fieldset>

                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" autofocus required="required"
                               title="Your first and last name">
                    </div>

                    <div class="field" title="sadfsadf">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required="required" title="We will respond to this address">
                    </div>

                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" title="If you prefer a phone call">
                    </div>

                    <div class="field">
                        <label for="contact_reason">Contact Reason</label>
                        <select id="contact_reason" name="contact_reason" required="required"
                                title="Tell us how we can we help you">
                            <option></option>
                            <option>General Inquiry</option>
                            <option>Product Support</option>
                            <option>New Business</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" cols="15" rows="5" required="required"
                                ></textarea>
                    </div>

                    <div class="field submit">
                        <input type="submit" value="Submit"/>
                    </div>

                </fieldset>

            </form>
        </div>

        <div class="address-wrapper clearfix">
            <!-- This is the container for the map -->
            <div class="street-address">123 Imaginary St, Suite 200 <br/>Atlanta, GA 30314</div>
            <div id="map-outer">
                <div id="map">&nbsp;</div>
            </div>
            <a href="#" class="get-directions-button" rel="#map-overlay">Get Directions</a>
        </div>

    </div>
</div>

<span id="company-street-address"><?php echo $company_address;?></span>

</body>
</html>