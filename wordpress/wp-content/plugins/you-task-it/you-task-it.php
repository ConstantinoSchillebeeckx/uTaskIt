<?php
/**
* Plugin Name: You Task It
* Description: Defines custom post type (task), removes user roles and handles forms for task and user profiles
* Version: 1.1.3
* Author: Constantino Schilebeeckx
* Author URI: https://photoscs.wordpress.com/
**/

/*

Plugin takes care of the following:
- creates custom post type (task)
- deletes unneeded user roles and creates new default (User)
- defines functions for generating input forms for adding tasks and users
- TODO

*/








/*------------------------------------*\
    Form Functions
\*------------------------------------*/




/* Send out email with SMTP instead of php mail()

Send as HTML


Parameters:
===========
TODO

Returns:
========
TODO

*/

function yti_SMTP( $to, $from, $subject, $body, $attachment = null ) {

    // Pear Mail Library
    require_once "Mail.php";

    $from = sprintf( 'UtaskIt <%s>', $from );
    $to = sprintf( '<%s>', $to );

    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject,
        'MIME-Version' => '1.0',
        'Content-type' => 'text/html; charset=iso-8859-1'
    );

    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'info@passioeducation.com',
            'password' => 'LJTcZUTZtr3Tw3'
    ));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo $mail->getMessage();
        return false;
    } else {
        return true;
    }


}

/* Send out an email based on an action

Parameters:
===========
TODO

Returns:
========
TODO

*/


function yti_send_email($type=null, $opts=null) {

    global $current_user;

    $from = get_option( 'admin_email' );
    $attachment = null;

    if ( in_array( $type, array( 'create_task', 'apply_to_task' ) ) ) {
        $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user->ID ) );
        $task_info = get_post( $opts['task_id'] );
        $task_meta = get_post_meta( $opts['task_id'] );
        $author_id = $task_info->post_author;
        $author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_id ) );
        $to =  $user_meta['user_email'];
        $fn = $user_meta['first_name'];
        $task_url = $task_info->guid;
        $task_title = $task_info->post_title;
    }

    switch ($type) {
        case "create_task":
            $subject = "You’ve created a new task!";
            $msg = sprintf("This is to confirm that you have successfully created the task <a href='%s'>%s</a>.<br>Consultants can begin applying to your task now. If a consultant applies to your task, we will send another email. Remember, your task can’t be completed until both the client and consultant agree to staff it, so be sure to check back for emails from UTaskiT!<br><br>If you want to hunt for a consultant yourself, you can see a list of available freelancers <a href='http://utaskit.com/?s&post_type=user'>here</a>.", $task_url, $task_title);
            $status = yti_SMTP($to, $from, $subject, $msg, $attachment);

            $subject = '[UtaskIt admin] new Task: ' . $task_title;
            $msg = sprintf( 'You\'re receiving this email because a <a href="%s">new Task</a> was created.<br><br>Thanks!', $task_url);
            $status = $status * yti_SMTP($from, $from, $subject, $msg, $attachment);
            break;
        case "apply_to_task":
            $subject = "You've applied for a task!";
            $msg = sprintf("You've applied for <a href='%s'>%s</a>!<br><br>If the client hires you, we will send another email. Remember, tasks are time-sensitive, so be sure that you’re available for any tasks that you apply to.<br><br>Happy tasking!", $task_url, $task_title);
            $status = yti_SMTP($to, $from, $subject, $msg, $attachment);

            $subject = "Your task has an application!";
            $msg = sprintf("<a href='%s/author/%s'>%s</a> is interested in staffing your task!<br><br>To hire this tasker, visit your <a href='%s/?action=view'>task</a>, choose the applicant and click hire.<br><br>Happy tasking!", get_home_url(), $user_meta['nickname'], $fn, $task_url);
            $status = $status * yti_SMTP($author_meta['user_email'], $from, $subject, $msg, $attachment);
            break;
        case "contact_user":
            $subject = 'Someone on UtaskIt has sent you a message';
            $body = sprintf('The user <a href="%s/author/%s">%s</a> has sent you a message:<br>', get_home_url(), $opts['nickname'], $opts['from_name']);
            $body .= $opts['body'];
            $to =  $opts['to'];
            $status = yti_SMTP($to, $from, $subject, $body, $attachment);
            break;
        case "hire_user":
            $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $opts['user_id'] ) );
            $task_info = get_post( $opts['task_id'] );
            $task_meta = get_post_meta( $opts['task_id'] );
            $to =  $user_meta['user_email'];
            $fn = $user_meta['first_name'];
            $subject = "Happy Tasking! You've been matched as a consultant!";
            $msg = sprintf("It’s a match! %s will complete %s by %s for $%s<br>%s will be removed from the list of available tasks.<br><br>Happy tasking!", $fn, $task_info->post_title, $task_meta['task_date'][0], $task_meta['budget'][0], $task_info->post_title);
            $status = yti_SMTP($to, $from, $subject, $msg, $attachment);

            $hiring_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $opts['person_hiring'] ) );
            $to =  $hiring_meta['user_email'];
            $fn = $hiring_meta['first_name'];
            $subject = "Happy Tasking! You've been matched as a client!";
            $status = yti_SMTP($to, $from, $subject, $msg, $attachment);
            break;
        case "accept_hire_request":
            $subject = '';
            $body = '';
            $to =  '';
            break;
        case "unhire":
            $task_info = get_post( $opts['task_id'] );
            $task_meta = get_post_meta( $opts['task_id'] );
            $author_id = $task_info->post_author;
            $author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_id ) );
            $task_url = $task_info->guid;
            $task_title = $task_info->post_title;

            $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $opts['user_id'] ) );
            $task_info = get_post( $opts['task_id'] );
            $task_meta = get_post_meta( $opts['task_id'] );
            $to =  $user_meta['user_email'];
            $fn = $user_meta['first_name'];
            $subject = "You have been dismissed from your task";
            $msg = sprintf("You have been dismissed from <a href='%s'>%s</a>. To browse more available tasks, please click <a href='%s/?s&post_type=task'>here</a>.", $task_url, $task_title, site_url());
            $status = yti_SMTP($to, $from, $subject, $msg, $attachment);

            $hiring_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $opts['person_hiring'] ) );
            $to2 =  $hiring_meta['user_email'];
            $fn2 = $hiring_meta['first_name'];
            $subject = "You have dismissed a consultant from your task";
            $msg = sprintf("You have dismissed the hired consultant %s from %s. Your task has been posted again in the available jobs list. Select a new consultant from the applications on your task page <a href='%s/tasks/%s/?action=view'>here</a>, or browse available consultants <a href='%s/?s&post_type=user'>here</a>.", $fn, $task_title, site_url(), $task_info->post_name, site_url());
            $status = yti_SMTP($to2, $from, $subject, $msg, $attachment);
            break;
    }
    return $status;
}





/*
Generates a user feedback message on the state of submitting a form

Parameters:
----------
- $msg : string
    message to send back in div
- $error : bool
    if true, we send back a success message (green) otherwise send
    back an error message

Returns:
-------
- proper html within bootstrap row of alert message
*/
function yti_user_feedback_message($msg, $error) {

    $html = '';
    if (isset($msg)) {
        $html .= '<div class="row">';
        $html .= '<div class="col-sm-12">';
        $html .= sprintf('<div class="alert %s alert-dismissible fade in" role="alert">', ($error == true) ? 'alert-danger' : 'alert-success');
        $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
        $html .= $msg;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
}




/*
HTML for user profile form, function called from User Profile template page.
This form is used in two ways:
1. traditionally to capture user input and submit any changes; this is done
from the user profile template page.  The form will be submitted to the DB
when the POST['action'] is set (it'll be set to "edit_user").
2. to display the user profile to others.  This occurs when the function is
called from the author template page with e.g. $user_id=3. In this case,
the form is used simply to display information to the person viewing the profile.
Instead of a "submit" button (for the form) a "contact user" button is displayed
which allows the logged-in user to contact the user.

By default, the generated form will pre-populate with any fields that are already
set within the DB.

When a form is being submitted, the $_POST['action'] will be either
: edit_user
: contact_user

Parameters:
==========
- $user_id : int
    if an int, the int represents the user ID currently being viewed
    the form will be shown for "viewing" with all input fields disabled and
    no submit button.  instead, a "contact author" button will be shown.
    if null, form will act like a standard one with a submit button for updating
    the user's profile.


*/
function yti_user_form($user_id=null) {

    global $current_user;

    echo '<h1>User profile</h1>';


    // only show form if a user is logged in
    if (!is_user_logged_in ()) {
        echo sprintf('<p class="lead">You must <a href="/wordpress/wp-login.php?redirect_to=%s">sign in</a> to view this page.</p>', get_permalink());
        return;
    };

    $action = 'edit_user';
    if ( !isset($_POST['action']) && isset( $_POST['remove_app'] ) ) {
        $action = 'remove_app';
    } else if ( $_POST['action'] == 'contact_user' ) {
        $action = 'contact_user';
    } else if ( $user_id != null ) {
        $action = 'view_user';
    }

    // update user meta if form was submitted
    if ( $action == 'remove_app' || $action == 'edit_user' ) {
        echo '<p class="lead">Please complete your profile by answering the following questions.</p>';
        if ( isset( $_POST['action'] ) && !isset( $_POST['remove_app'] ) ) {
            yti_process_edit_profile();
        } else if ($action == 'remove_app' ) {
            yti_remove_application($current_user->ID, $_POST['remove_app'] );
        }
        $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user->ID ) );
    } else if ($action == 'view_user' || $action == 'contact_user') { // display the form for viewing to others

        $user_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
        $current_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user->ID ) );

        // contact user if needed
        if ( $action == 'contact_user' ) {
            $opts = array(
                'to' => $user_meta['user_email'],
                'body' => $_POST['contact_user_text'],
                'from_name' => $current_user['first_name'],
                'nickname' => $current_user['nickname'],
            );
            $status = yti_send_email('contact_user', $opts );
            if ( $status ) {
                echo yti_user_feedback_message("Success, user has been contacted.", false);
            } else {
                echo yti_user_feedback_message(sprintf( "There was an error sending your message, please try again.  The body of the message was: %s", $_POST['contact_user_text'] ), true);
            }
        }

        $author_name = $user_meta['first_name'] . ' ' . $user_meta['last_name'];
        echo '<p class="lead"><code>' . $author_name . '</code></p>';
    } ?>


    <!-- load user form -->
    <?php require_once('user_form.php'); ?>

    <script>
        jQuery(document).ready(function ($) { // http://stackoverflow.com/a/10807237/1153897

            // disable all inputs if "viewing" profile if URL contains the word /author/
            if(window.location.href.indexOf("/author/") > -1) {
                $(user_form).find(':input,textarea,select').not('#contact_user_text').prop('readonly',true)
                $(user_form).find('input').prop('disabled',true) // for the file upload button
                $(user_form).find('select').prop('disabled',true)
                $(user_form).find(':radio').prop('disabled',true)
            }

            // disable submit button once form is submitted
            $("form").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });
            /*$('form').submit(function () {
                $(':submit').addClass("disabled");
                $(':submit').attr('disabled', true);
            });*/
        });

    </script>

    <script>
    jQuery(document).ready(function ($) { // http://stackoverflow.com/a/10807237/1153897
        $('.conditional').conditionize();
    });
    </script>
<?php }


/* Remove user's application to a task

Will remove the comment (which serves as an "application")
for the given user on the given task

Parameters:
-----------
- user_id : int
            ID of user for which to remove application
- task_id : int
            ID of task for which to remove application

*/
function yti_remove_application( $user_id, $task_id ) {

    global $wpdb;
    $table = $wpdb->prefix . 'comments';
    $wpdb->delete( $table, array('user_id' => $user_id, 'comment_post_ID' => $task_id) );

    // provide user with feedback
    echo yti_user_feedback_message("Success, application removed.", false);
}





/* XXX
function called when viewing a user profile and submitting the form
with the "contact user" button.  function will send out an email
to the user with the message from the textarea and provide feedback
to the sender

Parameter
---------
- email : string
    email of person being contacted
- msg : str
    message to send to the user

Return
------
nothing

function yti_contact_user($email, $msg) {

    add_filter( 'wp_mail_from', function( $email ) {
        return get_option( 'admin_email' );
    });
    add_filter( 'wp_mail_from_name', function( $name ) {
        return 'u Task it';
    });

    // Send email to to user
    $subject = 'Someone has contacted you regarding a task';
    if ( wp_mail( $email, $subject, $msg ) ) {
        // provide user with feedback
        echo yti_user_feedback_message("Success, user has been contacted.", false);
    } else {
        echo yti_user_feedback_message(sprintf( "There was an error sending your message, please try again.  The body of the message was: %s", $msg ), true);
    }


}

*/


/* XXX
Will email the task author when someone applies to it.

TODO

function yti_apply_for_task_email() {

    global $current_user;
    $owner_meta = get_user_meta(get_the_author_id());
    $to = $owner_meta['user_email'][0];

    add_filter( 'wp_mail_from', function( $email ) {
        return get_option( 'admin_email' );
    });
    add_filter( 'wp_mail_from_name', function( $name ) {
        return 'u Task it';
    });

    $sub = 'Someone applied to your task!';
    $msg = sprintf('The user <a href="#">%s</a> applied to your <a href="#">task</a>.', $current_user->first_name, get_permalink());
    wp_mail($to, $sub, $msg);

}


*/

/*
function is called on every submit of the form
generated by the "User Profile" template page

function expects $_POST to be filled with input field values

the function handles the following things:
- add data to the DB (if it is diff than current value)
- give user feedback on what was done
*/
function yti_process_edit_profile() {
    global $current_user;
    $current_meta = get_user_meta($current_user->ID);

    unset($_POST['action']); // so that we don't loop through it when updating user

    // loop through uploaded files
    if(file_exists($_FILES['cv_upload']['tmp_name']) && is_uploaded_file($_FILES['cv_upload']['tmp_name'])) {
        foreach( $_FILES as $file ) {
            if( is_array( $file ) ) {
                $attachment_url = yti_upload_user_file( $file );
                $_POST['cv'] = $attachment_url;
            }
        }
    }

    // go through each input in $_POST and check if
    // the meta it is different than the current value
    foreach($_POST as $key => $value) {
        if ($value != $current_meta[$key][0] && $value != '') {
            update_user_meta($current_user->ID, $key, $value);
            if (strpos($key, 'user_email') !== false) { // update email field that WP backend uses
                wp_update_user( array( 'ID' => $current_user->ID, 'user_email' => $value ) );
            }
        }
    }


    // provide user with feedback
    echo yti_user_feedback_message("Success, profile updated.", false);

}




/*
Function for handling file (CV) uploads, taken from
https://hughlashbrooke.com/2014/03/20/wordpress-upload-user-submitted-files-frontend/

Returns:
    full URL of attached file

*/
function yti_upload_user_file( $file = array() ) {
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );


    $file_return = wp_handle_upload( $file, array('test_form' => false ) );

    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        echo 'File upload error';
        return false;
    } else {

        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );

        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );

        if( 0 < intval( $attachment_id ) ) {
            return wp_get_attachment_url( $attachment_id );
        }
    }
    return false;
}


/*
HTML for task profile form, function called from Task Profile template page &
single-tasks.php

This form is used in three ways, regardless, the form is displayed:
1. Creating a Task
- no $task_id is provided, the form is blank, and all fields are editable
2. Editing a Task
- $task_id passed by GET['task_id'], the form is filled in with current info, and
all fields are editable.
3. Viewing a Task
- $task_id will be passed to function, the form is filled in with current info, and
all the input fields are disabled
4. Hire an applicant
- $_POST["hire_id"] wil lbe set to the user_id of the applicant just hired
for the task
By default, the generated form will pre-populate with any fields that are already
set within the DB.

Form submit:
when form is submitted, the $_POST['action'] will be one of four values:
> submit_task - when creating a new task
> apply_task - when a user is applying to a Task
> hire - when hiring someone for a task; additionally, $_POST['hire_id']
will be set, it will equal the user_id
of the person that was just hired for the task
> archive_task - when a user is deleting a task
> restore_task - when un-deleting task/un-hiring someone

Parameters:
==========
- $task_id : int
    if an int, the int represents the task ID currently being viewed.
    the form will be shown for "viewing" with all input fields disabled and
    no submit button.  instead, a "apply to task" button will be shown.
    if null, form will act like a standard one with a submit button for updating
    the user's profile.


*/
function yti_task_form($task_id=null) {

    global $current_user;

    // figure out why user is visiting task
    if ( isset( $_GET['task_id'] ) ) {
        $action = 'edit';
        $task_id = $_GET['task_id'];
    } else if ( $task_id != null ) {
        $action = 'view';
    } else {
        $action = 'create';
    }

    // check if form was submitted
    // if task is being created or edited -> submit_task
    // if task is being applied to -> apply_task
    if (isset( $_POST['action'] ) ) {
        $submit = $_POST['action'];
    }

    // only show form if a user is logged in
    if (!is_user_logged_in ()) {
        echo sprintf('<p class="lead">You must <a href="/wordpress/wp-login.php?redirect_to=%s">sign in</a> to view this page.</p>', get_permalink());
        return;
    }


    $milestone_ex = "For example:
(1)     Develop two surveys, one each for general practitioners and neurologists. Surveys should include qualitative and quantitative metrics, and be designed for an interview approximately 30 minutes in length. Survey will be approved by the company before interviewing begins.
(2)     Conduct interviews with 12-15 general practitioners according to the survey developed in (1). Interviews can be conducted in person or over the phone.
(3)     Conduct interviews with 8-10 neurologists according to the survey developed in (1). Interviews can be conducted in person or over the phone.
(4)     Perform quantitative analysis as appropriate for interviews conducted in (2) and (3). Summarize findings in one-page document.";

    // update task meta if form was submitted
    if ( $submit == 'submit_task' ) {
        yti_process_edit_task( (isset($task_id)) ? $task_id : null );
    }

    // apply to task if user requested
    if ( $submit == 'apply_task' ) {
        yti_apply_for_task();
    }

    if ( is_numeric($submit) ) {
        yti_hire_applicant( intval($submit), $task_id );
    }

    if ( $submit == 'archive_task' ) {
        yti_archive_task( $task_id, true );
    } else if ($submit == 'restore_task' ) {
        yti_restore_task( $task_id );
    }

    if ( isset( $task_id ) ) { // load meta if editing or viewing form
        $post_meta = array_map( function( $a ){ return $a[0]; }, get_post_meta( $task_id ) );
        $post_data = get_post( $task_id ); # https://codex.wordpress.org/Class_Reference/WP_Post
    }


    if ( $action == 'edit' ) {
        echo '<h1>Edit Task</h1>';
    } else if ( $action == 'view' ) {
        echo '<h1>View Task ';
        if (get_the_author_meta('ID') == $current_user->ID) {
            echo sprintf('<a href="/create-task/?task_id=%s" role="button" type="button" class="btn btn-info"><i class="fa fa-gear fa-lg"></i> Edit</a>', $task_id);
        }
        echo '</h1>';
    } else {
        echo '<h1>Create Task</h1>';
    }

    ?>


    <!-- load task form -->
    <?php require_once('task_form.php'); ?>

    <script>
        jQuery(document).ready(function ($) { // http://stackoverflow.com/a/10807237/1153897
            var action = '<?php echo $action; ?>';
            if(action == 'view') { // disable all inputs if viewing
                $(task_form).find(':input,textarea,select').prop('readonly',true)
                $(task_form).find('select').prop('disabled',true)
                $(task_form).find(':radio').prop('disabled',true)
            }

            $("form").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });
        });


        // NOTE: conditional divs are initially set to style="display: none;" so that they don't "flash" on initial page load
        jQuery(document).ready(function ($) { // http://stackoverflow.com/a/10807237/1153897
            $('.conditional').conditionize();
        });
    </script>

<?php }


/* Arhive a Task

When a person is hired for a task, or a user
wishes to remove a task, the task should be
archived (post_status = 'pending').

Paramters:
----------
- task_id : int
            task_id of task to be archived
- msg : bool
        if true, a feedback message is provided to user, otherwise
        make it silent

Returns:
-------
bool - true if task properly archived, false otherwise

*/

function yti_archive_task( $task_id, $msg = false ) {

    $status = wp_update_post(array('ID' => $task_id,'post_status'   => 'pending'));

    if ($msg && $status) {
        echo yti_user_feedback_message('Task has been archived.', false);
    } else if ($msg && !$status) {
        echo yti_user_feedback_message('There was an error archiving the Task, please try again.', true);
    }

    return $status;
}

/* Unarchive task

When a user wishes to unarchive task or unhire a person, 
the Task will be restored (post_status = publish)

Paramters:
----------
- task_id : int
            task_id of task to be restored

Returns:
-------
bool - true if task properly restored, false otherwise


*/

function yti_restore_task( $task_id ) {

    $status = wp_update_post(array('ID' => $task_id,'post_status'   => 'publish'));
    $dat = maybe_unserialize( get_post_meta( $task_id, 'hired', true ) ); // will be array of form array(user_id -> date)
    if ( is_array($dat) ) { // unhire
        $user_id = array_keys($dat)[0]; // there should be only one entry in this array since only one person can be hired
        delete_post_meta( $task_id, 'hired' );
        $dat = maybe_unserialize( get_user_meta( $user_id, 'hired', true ) ); // will be array of form array(task_id -> date, ...)
        unset($dat[$task_id]); // remove key-value for task since a user can have multiple hired tasks
        update_user_meta( $user_id, 'hired', $dat );
        yti_send_email('unhire', array('user_id' => $user_id, 'task_id' => $task_id, 'person_hiring' => get_current_user_id()));
    }

    if ($status) {
        if ($user_id > 0) {
            echo yti_user_feedback_message('The applicant has been un-hired', false);
        } else {
            echo yti_user_feedback_message('Task has been restored.', false);
        }
    } else {
        echo yti_user_feedback_message('There was an error restoring the Task, please try again.', true);
    }

    return $status;
}





/* Hire an applicant for a task

Function is called from yti_task_form whenever a task
owner clicks on the "Hire" button of the task.  This
will hire the person for the particular task.  function
will update user meta to reflect person has been hired for
this task and the task meta will be updated to reflect
person is working on task.  

Data is stored in the 'hired' key as assoc array in form -
    post_meta: array(user_id -> hired_date)
    user_meta: array(task_id -> hired_date)

Parameters:
===========
- user_id : int
    id of person being hired
- task_id : int
    id of task being hired for

*/

function yti_hire_applicant($user_id, $task_id) {

    global $current_user;

    if ($user_id > 0 && $task_id > 0) {
        // update post meta
        // assign the "hired" key to supplied user id
        // and set the "hired_date" key to now
        $dat = get_post_meta( $task_id, 'hired', true );
        if ( is_array($dat) ) {
            $dat[$user_id] = date("Y-m-d H:i:s");
        } else {
            $dat = array($user_id => date("Y-m-d H:i:s"));
        }
        $err1 = yti_update_post_meta( $task_id, 'hired', $dat );
        $err3 = yti_archive_task( $task_id );

        // update user meta
        // add task_id to the "hired" array
        // and set the "hired"date" key to now
        $dat = get_user_meta( $user_id, 'hired', true );
        if ( is_array($dat) ) {
            $dat[$task_id] = date("Y-m-d H:i:s");
        } else {
            $dat = array($task_id => date("Y-m-d H:i:s"));
        }
        $err4 = update_user_meta( $user_id, 'hired', $dat );

        // send emails
        $opts = array(
            'task_id' => $task_id,
            'user_id' => $user_id,
            'person_hiring' => $current_user->ID,
        );
        $err6 = yti_send_email('hire_user', $opts);
    } else {
        $err1 = false;
    }

    // feedback message
    if ( $err1 == true && $err3 == true && $err4 == true && $err6 == true ) {
        $name = get_user_meta( $user_id, 'first_name', true );
        $msg = "Success, you've hired <b>" . $name . "</b> for this task.";
        $msg .= "<br><br>The task has <u>automatically been closed</u> and an email has been sent to " . $name;
        echo yti_user_feedback_message($msg, false);
    } else {
        echo yti_user_feedback_message("There was an error hiring the applicant, please try again.", true);
    }

}







/*
function is called on every submit of the form generated by yti_task_form()

the function handles the following things:
- add data to the DB
- provides a feedback message to the user
- sends out an email to the author
- sends out an email to admin

Parameters:
----------
    - task_id : int
        optional value for task id if it is being updated instead of
        newly created, when passed the feedbkack message is changed
        and a post is updated instead of newly created

*/
function yti_process_edit_task( $task_id = null ) {

    $current_user = wp_get_current_user();
    $error = true;

    // check if post was previously 'pending'
    $status = get_post_status( $task_id );
    if ( $status == '' ) {
        $status = 'publish';
    }

     // Create post object
     // contains the following data https://codex.wordpress.org/Class_Reference/WP_Post
     // all other data stored as meta data
    $my_post = array(
        'ID'            => $task_id,
        'post_title'    => sanitize_text_field( $_POST['task_title'] ),
        'post_name'    => sanitize_text_field( $_POST['task_title'] ),
        'post_content'  => sanitize_text_field( $_POST['task_descrip'] ),
        'post_status'   => $status,
        'post_type'     => 'task',
        'post_author'   => sanitize_user($current_user->ID),
    );


    // Insert the post into the database
    $post_id = wp_insert_post( $my_post );
    if ($post_id != 0) { // if successfully added task, update the metadata

        // unset fields already added by wp_insert_post
        unset($_POST['action']);
        unset($_POST['task_title']);
        unset($_POST['task_descrip']);

        $error = false;


        // add each remaining key in $_POST as post meta
        foreach ($_POST as $key => $val) {
            yti_update_post_meta( $post_id, sanitize_text_field($key), sanitize_text_field($val) );
        }

        // provide user with feedback
        if ( $task_id ) {
            $msg = 'Your task was updated.';
        } else {
            $msg = 'Your task was successfully created.';
            yti_send_email('create_task', array( 'task_id' => $post_id ) );
        }

    } else {
        $msg = 'An error occurred while ' . ( $task_id ) ? 'updating' : 'adding' . ' your task';
    }

    echo yti_user_feedback_message($msg, $error);


}



/**
  * Updates post meta for a post. It also automatically deletes or adds the value to field_name if specified
  *
  * @access     protected
  * @param      integer     The post ID for the post we're updating
  * @param      string      The field we're updating/adding/deleting
  * @param      string      [Optional] The value to update/add for field_name. If left blank, data will be deleted.
  * @return     update wp_err
  */
function yti_update_post_meta( $post_id, $field_name, $value = '' )
{
    if ( empty( $value ) OR ! $value )
    {
        $status = delete_post_meta( $post_id, $field_name );
    }
    elseif ( ! get_post_meta( $post_id, $field_name ) )
    {
        $status = add_post_meta( $post_id, $field_name, $value );
    }
    else
    {
        $status = update_post_meta( $post_id, $field_name, $value );
    }
    return $status;
}




/*
function call for applying to a task, called from the custom post type (task)

applications to a task will be handled through the post comments.  Everytime
someone applies to a tasks, a comment will be added to that tasks.  All comments
are pending (must be approved) by default. The comment that is accepted, is the
user that is accepted for the task.

function then creates a new comment on the post with the current user

Returns:
returns true if properly applied to task,
false otherwise
*/
function yti_apply_for_task() {
    global $post, $current_user;


    if ($post->post_type == 'task') { // add comment if we have everything

        $commentdata = array(
            'comment_post_ID' => $post->ID,
            'comment_author' => $current_user->first_name . ' ' . $current_user->last_name,
            'comment_author_email' => $current_user->user_email,
            'comment_content' => time(), // add random comment content to allow for multiple applications to task
            'comment_approved'=> 0,
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => $current_user->ID,
        );

        //Insert new comment and set it to unapproved
        $comment_ID = wp_insert_comment( $commentdata );
        yti_send_email('apply_to_task', array( 'task_id' => $post->ID ) );

        if ($comment_ID) {
            echo yti_user_feedback_message("Success, you've applied for this Task.", false);
            return true;
        } else {
            echo yti_user_feedback_message("There was an error applying for this Task.", true);
            return false;
        }
    }
    return false;
}




// function check whether a user has applied
// to current task
// Returns:
// true if has applied (comment is pending)
// false otherwise
function yti_user_has_applied_to_task( $task_id ) {
    global $wpdb, $current_user;
    $comment_count = $wpdb->get_var(
        "SELECT COUNT( * ) AS total FROM {$wpdb->comments} WHERE comment_approved not like '%trash%' AND user_id = " . $current_user->ID . " AND comment_post_ID = " . $task_id
    );
    if (intval($comment_count) > 0) {
        return true;
    } else {
        return false;
    }
}

/* List all Tasks that a user has applied to

Parameters:
-----------
- user_id : int
            ID for which user to display Tasks for

*/
function yti_list_applications( $user_id ) {

    // query applicants
    global $wpdb;
    $rows = $wpdb->get_results(
        "SELECT *
        FROM {$wpdb->comments}
        WHERE comment_approved not like '%trash%' AND user_id = " . $user_id
    );

    $html = '';
    if ( $rows != null ) {
        $html .= '<label>Applied Taks:</label><br>';
        $html .= '<div class="row"><div class="col-sm-8">';
        $html .= '<table class="table table-bordered table-hover table-responsive">';
        $html .= '<thead class="alert-warning"><tr>';
        $html .= '<th>Task</th>';
        $html .= '<th>Date</th>';
        $html .= '<th></th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach ( $rows as $task ) {
            $user_meta = array_map( function( $a ){ return maybe_unserialize($a[0]); }, get_user_meta( $task->user_id ) );
            $task_id = $task->comment_post_ID;
            $date = $task->comment_date;
            $task = get_post($task_id);
            $title = $task->post_title;
            $url = sprintf('/?post_type=task&p=%s&preview=true', $task->ID);

            $html .= '<tr>';
            $html .= sprintf('<td><a href="%s">%s</td>', $url, $title); // . $task->post_title . '</td>';
            $html .= '<td>' . date( 'Y-m-d', strtotime( $date ) ) . '</td>';
            if ( array_key_exists($task_id, $user_meta['hired']) ) {  // if person was hired for task
                $html .= sprintf('<td class="text-center"><button disabled type="submit" class="btn btn-success btn-xs" name="remove_app" value="%s">Hired</button></td>', $task_id);
            } else {
                $html .= sprintf('<td class="text-center"><button type="submit" class="btn btn-info btn-xs" name="remove_app" value="%s">Remove application</button></td>', $task_id);
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div></div>';
    }

    echo $html;

}





/* Generates a table of applicants to a task

When the author of a task views their own task,
they will be shown a table of all the people that
have applied to their task.

Paramters:
----------
- task_id : int
    the task ID for which to generate a table
    of applicants

Returns:
--------
- nothing: does an echo of all HTML needed. if
    applicants exist, a table is generated listing
    each applicant along with a link to their
    profile and a "hire" button.  If none exist, a
    message communicating that is echo-ed.

*/

function yti_list_applicants( $task_id ) {
    echo '<label>Applicants</label><br>';

    // query applicants
    global $wpdb;
    $applicants = $wpdb->get_results(
        "SELECT * FROM {$wpdb->comments} WHERE comment_approved not like '%trash%' AND comment_post_ID = " . $task_id
    );

    $task_hire = get_post_meta( $task_id, 'hired', true ); // will be an array(user_id -> date) if someone was already hired

    $html = '';
    if ( $applicants == null ) {
        $html .= '<code>No one has applied to your task yet.</code>';
    } else {
        $html .= '<div class="row"><div class="col-sm-6">';
        $html .= '<table class="table table-bordered table-hover table-responsive">';
        $html .= '<thead class="alert-warning"><tr>';
        $html .= '<th>Name</th>';
        $html .= '<th class="text-center">CV</th>';
        $html .= '<th>Applied on</th>';
        $html .= '<th></th>';
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach ( $applicants as $person ) {
            $user_meta = array_map( function( $a ){ return maybe_unserialize($a[0]); }, get_user_meta( $person->user_id ) );
            $url = '/author/' . $user_meta['nickname'];

            $html .= ( is_array($user_meta['hired']) ) ? '<tr class="success">' : '<tr>' ;
            $html .= '<td><a href="'. $url . '">' . $person->comment_author . '</a></td>';
            $html .= '<td class="text-center"><a href="'. $user_meta['cv'] . '"><i class="fa fa-file-text" aria-hidden="true"></i></a></td>';
            $html .= '<td>' . date( 'Y-m-d', strtotime( $person->comment_date ) ) . '</td>';

            if ( is_array($user_meta['hired']) && in_array($task_id, $user_meta['hired']) ) {
                $html .= '<td class="text-center"><button type="submit" class="btn btn-xs btn-success" disabled="disabled" value="' . $person->user_id . '" name="hire_id">Hired</button></td>';
            } else {
                if ( $task_hire > 0 ) { // if someone has already been hired, disable hire button
                    $html .= '<td class="text-center"><button type="submit" disabled="disabled" class="btn btn-xs btn-warning" value="' . $person->user_id . '" name="hire_id">Hire</button></td>';
                } else {
                    $html .= '<td class="text-center"><button type="submit" name="action" class="btn btn-xs btn-warning" value="' . $person->user_id . '" name="hire_id">Hire</button></td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div></div>';
    }

    echo $html;

}



/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

// Create custom post type for tasks
// https://premium.wpmudev.org/blog/creating-content-custom-post-types/
function yti_create_post_type()
{
    register_post_type('task', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Tasks', 'yti'), // Rename these to suit
            'singular_name' => __('Task', 'yti'),
            'add_new' => __('Add New', 'yti'),
            'add_new_item' => __('Add New Task', 'yti'),
            'edit' => __('Edit', 'yti'),
            'edit_item' => __('Edit Task', 'yti'),
            'new_item' => __('New Task', 'yti'),
            'view' => __('View Task', 'yti'),
            'view_item' => __('View Task', 'yti'),
            'search_items' => __('Search Task', 'yti'),
            'not_found' => __('No Tasks found', 'yti'),
            'not_found_in_trash' => __('No Tasks found in Trash', 'yti')
        ),
        'public' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            // 'excerpt',
            // 'custom-fields',
            // 'thumbnail',
            'page-attributes',
            // 'comments',
            'revisions',
        ),
        'exclude_from_search' => false,
        'can_export' => true, // Allows export in Tools > Export
        'capability_type' => 'post',
        'rewrite' => array( 'slug' => 'tasks' ),
    ));
    flush_rewrite_rules();
}
add_action('init', 'yti_create_post_type'); // Add our Task Type


// add custom columns to tasks
function yti_custom_columns($columns) {
    unset( $columns['date'] );
    $columns['author'] = __('Author');
    $columns['comments'] = __('Appl.');
    $columns['date'] = __('Date');

    return $columns;
}
add_filter( 'manage_task_posts_columns', 'yti_custom_columns' );
// add_action( 'manage_task_posts_custom_column' , 'yti_custom_columns', 10, 2 );


// make custom columns sortable
function yti_sortable_column( $columns ) {
    $columns['author'] = 'author';

    return $columns;
}
add_filter( 'manage_edit-task_sortable_columns', 'yti_sortable_column' );



// customize the admin menu
// http://code.tutsplus.com/articles/customizing-your-wordpress-admin--wp-24941
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[25][0] = 'Applications';
    $submenu['edit-comments.php'][0][0] = 'Applications';

    remove_menu_page('edit.php'); // Remove the Posts Menu
    remove_menu_page('link-manager.php'); // Remove the Links Menu
}
add_action( 'admin_menu', 'change_post_menu_label' );






// Add custom metadata boxes for task data
// add_action("admin_init", "yti_custom_meta");
/*
function yti_custom_meta(){
  add_meta_box("yti_due_date_meta-meta", "Due date", "yti_due_date_meta", "task", "side", "low");
  add_meta_box("yti_deliverables_meta", "Deliverables", "yti_deliverables_meta", "task", "normal", "low");
}

function yti_due_date_meta(){
  global $post;
  $custom = get_post_custom($post->ID);
  $due_date = $custom["due_date"][0];
  ?>
  <label>Year:</label>
  <input name="due_date" value="<?php echo $due_date; ?>" />
  <?php
}

function yti_deliverables_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $deliverables = $custom["deliverables"][0];
  ?>
  <p><label>Deliverables:</label><br />
  <textarea cols="50" rows="5" name="deliverables"><?php echo $deliverables; ?></textarea></p>
  <?php
}

// save any modified task data
function yti_save_details(){
  global $post;

  update_post_meta($post->ID, "due_date", $_POST["due_date"]);
  update_post_meta($post->ID, "deliverables", $_POST["deliverables"]);
}
// add_action('save_post', 'yti_save_details');

*/

/*------------------------------------*\
    Custom User Roles
\*------------------------------------*/

/*
    One new role is created in order
    to reduce ambiguity regarding user
    roles.  A user will be able both to
    post a task as well as apply to them.
    This prevents people from creating
    multiple users.
    - user: same roles as Author

    The following roles are removed
    to reduce confusion:
    - Subscriber
    - Contributor
    - Author
    - Editor


*/
function yti_add_roles_on_plugin_activation() {
    // user role for people creating tasks
    add_role( 'client', 'Client', array(
        'read' => true,
        'delete_posts' => true,
        'delete_published_posts' => true,
        'edit_posts' => true,
        'edit_published_posts' => true,
        'publish_posts' => true,
        'upload_files' => false,
    ) );
    // user role for people doing task
    remove_role( 'consultant' );
    add_role( 'consultant', 'Consultant', array(
        'read' => true,
        'delete_posts' => false,
        'delete_published_posts' => false,
        'edit_posts' => false,
        'edit_published_posts' => false,
        'publish_posts' => false,
        'upload_files' => false,
    ) );
    remove_role( 'subscriber' );
    remove_role( 'author' );
    remove_role( 'editor' );
    remove_role( 'contributor' );
    update_option('default_role', 'consultant');
}
register_activation_hook( __FILE__, 'yti_add_roles_on_plugin_activation' );




// don't allow non-admins to view backend
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}
