<?php

return [
    'no_space'  => "No space please and don't leave it empty",
    'no_space_password'     => "Please enter valid password",
    'valid_mobile'          => "Please insert valid mobile number",
    'valid_password'        => "Password required at least 8 characters with one uppercase letter,one lowercase letter, numbers, special character",
    'web'=>[
        'only_image_validation' => 'Please upload jpg,png,jpeg image only',
        'landing_page' => [
            'title' => 'Rise'
        ],
        'user' => [
            'profile_photo_required'            => 'Please select profile image',
            'name_required'        => 'Please enter name.',
            'state_id_required'          => 'Please select state.',
            'district_id_required'          => 'Please select district.',
            'taluka_id_required'          => 'Please select taluka.',
            'pincode_id_required'          => 'Please select pincode.',
            'gst_number_required'          => 'Please select gst number.',
            'email_required'                    => 'Please enter email/phone no. address',
            'password_required'                 => 'Please enter password',
            // 'password_required'                 => "Password required at least 8 character with one uppercase letter,one lowercase letter, numbers, special character",
            "confirm_password_required"         => "Confirm password required at least 8 character with one uppercase letter,one lowercase letter, numbers, special character",
            'email_format'                      => 'Please enter valid email address.',
            'pwcheck'                           => 'Password is not strong enough',
            'checklower'                        => 'Need atleast 1 lowercase letter',
            'checkupper'                        => 'Need atleast 1 uppercase letter',
            'checkdigit'                        => 'Need atleast 1 digit',
            'phone_number_required'           => 'Please enter phone number',
            'address_required'                  => 'Please enter address',
            'bio_required'                      => 'Please enter description',
            'organization_register_success'     => 'You have Successfully Registered',
            'confirm_password_required'         => 'Please enter confirm password',
            'equal_pass'                        => 'Enter Confirm Password Same as Password',
            'profile_update_success'            => 'Organization profile has been updated successfully',

            'old_password_required'         => 'Old password is required',
            'new_password_required'         => 'New password is required',
            'confirm_password_required'     => 'Confirm password is required',
            'confirm_new_password_not_match'    => 'Confim password and new password should be same',
            'toscheck_required' => 'By creating an account, you must agree to accept our terms of service.'
            
          
        ]
    ],
    // API messages
    'api' => [
        'authentication_err_message'    => 'Authentication token has expired.',
        'something_went_wrong'          => 'Something went wrong.',
        'logout'                        => 'Account logged out successfully.',
        'user'  => [
            'email_already_exist'                       => 'That email address is already registered',
            'user_not_found'                            => 'User not found.',
            'email_or_password_incorrect'               => 'Email id or password is incorrect.',
            'register_success' => 'User register successfully.',
            'invalid_phone' =>'Please enter a valid phone number.',
            'user_get_profile_success'                  => 'User profile get successfully.',
            'profile_setup_success'                     => 'profile updated successfully.',
            'invalid_otp' => 'Verification code is not valid.',
            'user_login_success'                        => 'User login successfully.',
            'phone_already_exist'                       => 'That phone number is already registered',           
            'user_disable' =>'You will be approved by admin within 24 hours.',
            'user_reset_password_email_sent_fail'       => 'Email not send. please try again.',
            'user_reset_password_email_sent_success'    => 'Reset password link sent successfully on your requested email.',
            'confirm_new_password_not_match'    => 'New password and Confirm password does not matched',
            'change_password_success'       => 'Password changed successfully',
            'old_password_required'             => 'Old password is required',
            'new_password_required'             => 'New password is required',
            'confirm_password_required'         => 'Confirm password is required',
            'current_password_not_match'        => 'Current password does not match',
            'new_password_minlength'            => 'Password cannot less than 6 characters',
            'new_password_maxlength'            => 'Password cannot greater than 20 characters',
            'confirm_password_minlength'        => 'Confim password cannot less than 6 characters',
            'confirm_password_maxlength'        => 'Confim password cannot greater than 20 characters',
            'confirm_new_password_not_match'    => 'Confim password and new password should be same',
            'password_should_different'         => 'Old password and new password should not be same.',
            'invalid_oldpassword' => 'Incorrect old password.',
            'user_disable' => 'Your account is disabled.'
        ],
        'category' => [
            'category_get_success' => 'Category data get successfully.',
            'sub_category_get_success' => 'Sub Category data get successfully.',
        ],
        'service' => [
            'service_get_success' => 'Service data get successfully.',
        ],
        'banner'=> [
            'banner_get_success' => 'Banner data get successfully.',
        ],
        'order' =>[
            'order_add_success' => 'Order placed successfully',
            'order_get_success' => 'Get order data successfully',
            'order_not_found'  => 'Order not found.',
            'order_status_update_success' => 'Order status updated successfully',
            'order_cancel_success' =>'Your request is cancelled.',
        ],
        'cart' => [
            'service_not_found' => 'Service not found.',
            'cart_get_success' => 'Cart data get successfully.',
            'out_of_stock' => 'Out of stock.',
            'cart_delete_success' => 'Cart data deleted successfully.',
            'cart_not_found' => 'Cart data not found.',
            'add_cart_success' =>'Added in cart successfully.',
            'some_error' =>'Some error occured.',
            'cart_updated_success'=> 'Cart data updated successfully.',
        ],
        'setting' =>[
            'setting_get_success' => 'Setting get successfully.',
        ],
        'notification' => [
            'notification_sent_success'     => 'Notification sent successfully.',
            'notification_sent_error'       => 'Notification not sent successfully.',
            'notification_get_success'      => 'Notification get successfully.',
            'notification_count_success'    => 'Notification count.',
            'notification_read_success'     => 'Read notification successfully',
            'notification_not_found'        => 'Notification not found.',
            'notification_delete_success'   =>'Notification deleted successfully.'
        ],
        'state'=> [
            'state_get_success' => 'State data get successfully.',
        ],
        'district'=> [
            'district_get_success' => 'District data get successfully.',
        ],
        'taluka'=> [
            'taluka_get_success' => 'Taluka data get successfully.',
        ],
        'pincode'=> [
            'pincode_get_success' => 'Pincode data get successfully.',
        ],
        'testimonial' => [
            'testimonial_get_success' => 'Testimonial data get successfully.',
        ],
    ],
    // Admin messages
    'admin' => [
        'logout'    => 'You successfully logout from admin panel',
        'user' => [
            'email_required'                    => 'Please enter email address',
            'password_required'                 => 'Please enter password',
            'email_format'                      => 'Your email address must be in the format of name@domain.com',

            'update_profile_success'            => 'Profile updated successfully',
            'update_password_success'           => 'Password updated successfully',
            'old_password_required'             => 'Old password is required',
            'new_password_required'             => 'New password is required',
            'confirm_password_required'         => 'Confirm password is required',
            'current_password_not_match'        => 'Current password does not match',
            'new_password_minlength'            => 'Password cannot less than 6 characters',
            'new_password_maxlength'            => 'Password cannot greater than 20 characters',
            'confirm_password_minlength'        => 'Confim password cannot less than 6 characters',
            'confirm_password_maxlength'        => 'Confim password cannot greater than 20 characters',
            'confirm_new_password_not_match'    => 'Confim password and new password should be same',
            
            'delete_user_success'               => 'User has been delete successfully'
        ],
    ],
];