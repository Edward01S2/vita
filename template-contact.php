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
								<div class="social-icons">
									<a href="https://www.facebook.com/pages/category/Artist/Vita-nellarte-life-in-art-847365978733950/" target="_blank" class="facebook">
									<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 512"><path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path></svg>
									</a>
									<a href="https://instagram.com/patriciasaadabaumann" target="_blank" class="instagram">
									<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m305 256c0 27.0625-21.9375 49-49 49s-49-21.9375-49-49 21.9375-49 49-49 49 21.9375 49 49zm0 0"/><path d="m370.59375 169.304688c-2.355469-6.382813-6.113281-12.160157-10.996094-16.902344-4.742187-4.882813-10.515625-8.640625-16.902344-10.996094-5.179687-2.011719-12.960937-4.40625-27.292968-5.058594-15.503906-.707031-20.152344-.859375-59.402344-.859375-39.253906 0-43.902344.148438-59.402344.855469-14.332031.65625-22.117187 3.050781-27.292968 5.0625-6.386719 2.355469-12.164063 6.113281-16.902344 10.996094-4.882813 4.742187-8.640625 10.515625-11 16.902344-2.011719 5.179687-4.40625 12.964843-5.058594 27.296874-.707031 15.5-.859375 20.148438-.859375 59.402344 0 39.25.152344 43.898438.859375 59.402344.652344 14.332031 3.046875 22.113281 5.058594 27.292969 2.359375 6.386719 6.113281 12.160156 10.996094 16.902343 4.742187 4.882813 10.515624 8.640626 16.902343 10.996094 5.179688 2.015625 12.964844 4.410156 27.296875 5.0625 15.5.707032 20.144532.855469 59.398438.855469 39.257812 0 43.90625-.148437 59.402344-.855469 14.332031-.652344 22.117187-3.046875 27.296874-5.0625 12.820313-4.945312 22.953126-15.078125 27.898438-27.898437 2.011719-5.179688 4.40625-12.960938 5.0625-27.292969.707031-15.503906.855469-20.152344.855469-59.402344 0-39.253906-.148438-43.902344-.855469-59.402344-.652344-14.332031-3.046875-22.117187-5.0625-27.296874zm-114.59375 162.179687c-41.691406 0-75.488281-33.792969-75.488281-75.484375s33.796875-75.484375 75.488281-75.484375c41.6875 0 75.484375 33.792969 75.484375 75.484375s-33.796875 75.484375-75.484375 75.484375zm78.46875-136.3125c-9.742188 0-17.640625-7.898437-17.640625-17.640625s7.898437-17.640625 17.640625-17.640625 17.640625 7.898437 17.640625 17.640625c-.003906 9.742188-7.898437 17.640625-17.640625 17.640625zm0 0"/><path d="m256 0c-141.363281 0-256 114.636719-256 256s114.636719 256 256 256 256-114.636719 256-256-114.636719-256-256-256zm146.113281 316.605469c-.710937 15.648437-3.199219 26.332031-6.832031 35.683593-7.636719 19.746094-23.246094 35.355469-42.992188 42.992188-9.347656 3.632812-20.035156 6.117188-35.679687 6.832031-15.675781.714844-20.683594.886719-60.605469.886719-39.925781 0-44.929687-.171875-60.609375-.886719-15.644531-.714843-26.332031-3.199219-35.679687-6.832031-9.8125-3.691406-18.695313-9.476562-26.039063-16.957031-7.476562-7.339844-13.261719-16.226563-16.953125-26.035157-3.632812-9.347656-6.121094-20.035156-6.832031-35.679687-.722656-15.679687-.890625-20.6875-.890625-60.609375s.167969-44.929688.886719-60.605469c.710937-15.648437 3.195312-26.332031 6.828125-35.683593 3.691406-9.808594 9.480468-18.695313 16.960937-26.035157 7.339844-7.480469 16.226563-13.265625 26.035157-16.957031 9.351562-3.632812 20.035156-6.117188 35.683593-6.832031 15.675781-.714844 20.683594-.886719 60.605469-.886719s44.929688.171875 60.605469.890625c15.648437.710937 26.332031 3.195313 35.683593 6.824219 9.808594 3.691406 18.695313 9.480468 26.039063 16.960937 7.476563 7.34375 13.265625 16.226563 16.953125 26.035157 3.636719 9.351562 6.121094 20.035156 6.835938 35.683593.714843 15.675781.882812 20.683594.882812 60.605469s-.167969 44.929688-.886719 60.605469zm0 0"/></svg>              </a>
								</div>  
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