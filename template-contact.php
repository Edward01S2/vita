<?php
/*
Template Name: Contact Page
*/

/* Contact Form Processing
================================================== */
$name_error = '';
$email_error = '';
$subject_error = '';
$message_error = '';
$captcha_error = '';

$captcha = of_get_option('of_spam_question');

if (!isset($_REQUEST['c_submitted'])) {
	//If not isset -> set with dumy value 
	$_REQUEST['c_submitted'] = ""; 
	$_REQUEST['c_name'] = "";
	$_REQUEST['c_email'] = "";
	$_REQUEST['c_message'] = "";
}

if($_REQUEST['c_submitted']){

	//check name
	if(trim($_REQUEST['c_name'] == "")){
		//it's empty
		
		$name_error = __('You forgot to fill in your name', 'framework');
		$error = true;
	}else{
		//its ok
		$c_name = trim($_REQUEST['c_name']);
	}

	//check email
	if(trim($_REQUEST['c_email'] === "")){
		//it's empty
		$email_error = __('Your forgot to fill in your email address', 'framework');
		$error = true;
	}else if(!is_email( trim($_REQUEST['c_email'] ) )) {
		//it's wrong format
		$email_error = __('Wrong email format', 'framework');
		$error = true;
	}else{
		//it's ok
		$c_email = trim($_REQUEST['c_email']);
	}
	
	//check captcha
	if ($captcha == 'on') {
		if(trim($_REQUEST['c_captcha'] !== "4")){
			//it's empty
			$captcha_error = __('Please try answering this again.', 'framework');
			$error = true;
		}
	}

	//check name
	if(trim($_REQUEST['c_message'] === "")){
		//it's empty
		$message_error = __('You forgot to fill in your message', 'framework');
		$error = true;
	}else{
		//it's ok
		$c_message = trim($_REQUEST['c_message']);
	}

	//if no errors occured
	if($error != true) {

		$email_to = of_get_option('of_mail_address');
		if (!isset($email_to) || ($email_to == '') ){
			$email_to = get_option('admin_email');
		}
		$c_subject = __('Contact from your site', 'framework');
		$message_body = "Name: $c_name \n\nEmail: $c_email \n\nComments: $c_message";
		$headers = 'From: '.get_bloginfo('name').' <'.$c_email.'>';

		wp_mail($email_to, $c_subject, $message_body, $headers);

		$email_sent = true;
	}

}

/* Add validate script */
global $add_validate;
$add_validate = true;
		
		
/* Begin Page Content
================================================== */
get_header(); ?>

<?php 
/* #Get Page Title
======================================================*/
get_template_part('functions/templates/page-title-rotator'); ?>

<div id="postcontainer">
    <div class="container">
        <div class="ten columns singlecontent">
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
				<?php if(isset($email_sent) && $email_sent == true){ // If email was submitted ?>
                    <div class="emailsuccess">
                        <h4><?php if ($sentheading = of_get_option('of_sent_heading')) { echo $sentheading; } ?></h4>
                        <p><?php if ($sentdescription = of_get_option('of_sent_description')) { echo $sentdescription; } ?></p>
                    </div>
            <?php } 
            else { the_content(); } // If email isn't send, display post content ?>
			
			<?php if($error != '') { ?>
				<div class="emailfail">
                    <h4><?php _e('There were errors in the form.', 'framework'); ?></h4>
                    <p><?php _e('Please try again.', 'framework'); ?></p>
                </div>
			<?php } ?>
			
            <!-- Contact Form -->
            <div class="contactcontent">
                <div id="contact-form">
                    <form action="<?php the_permalink(); ?>" id="contactform" method="post" class="contactsubmit">
                        <div class="formrow">
                            <div class="one-half">
                                <label for="c_name">
                                    <?php _e('Name', 'framework'); ?>
                                </label>
                                <input type="text" name="c_name" id="c_name" size="22" tabindex="1" class="required" />
                                <?php if($name_error != '') { ?>
                                <p><?php echo $name_error;?></p>
                                <?php } ?>
                            </div>
                            <div class="one-half column-last">
                                <label for="c_email">
                                    <?php _e('Email', 'framework');?>
                                </label>
                                <input type="text" name="c_email" id="c_email" size="22" tabindex="1" class="required email" />
                                <?php if($email_error != '') { ?>
                                <p><?php echo $email_error;?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="messagerow">
                            <label for="c_message">
                                <?php _e('Message', 'framework'); ?>
                            </label>
                            <textarea name="c_message" id="c_message" cols="100%" rows="8" tabindex="3" class="required"></textarea>
                            <?php if($message_error != '') { ?>
                            <p><?php echo $message_error;?></p>
                            <?php } ?>
                        </div>
						
						<?php if ($captcha == 'on') : ?>
						<div class="one-half">
							<div class="messagerow">
								<label for="c_captcha">
										<?php _e('What is 5 - 1?', 'framework');?>
								</label>
								<input type="text" name="c_captcha" id="c_captcha" size="22" tabindex="4" class="required captcha" />
								<?php if($captcha_error != '') { ?>
									<p class="error"><?php echo $captcha_error;?></p>
								<?php } ?>
							</div>
						</div><div class="clear"></div>
						<?php endif; ?>
						
                        <p>
                            <label for="c_submit"></label>
                            <input type="submit" name="c_submit" id="c_submit" class="button" value="<?php _e('Send Message', 'framework'); ?>"/>
                        </p>
                        <input type="hidden" name="c_submitted" id="c_submitted" value="true" />
                    </form>
                    </div>
                <div class="clear"></div>
            </div>
            <!-- END Contact Form -->    
            <div class="clear"></div>                
            <?php endwhile; endif; ?>
        </div> 

        <!-- Sidebar -->
        <div class="five columns offset-by-one">
          <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Contact Sidebar') ) ?>
        </div> 
        <!-- End Sidebar -->

    </div><div class="clear"></div>
</div>

<?php 
/* Get Footer
================================================== */
get_footer(); ?>