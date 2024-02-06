
    <!-- All Script JS Plugins here  -->

    <script src="{{ url('assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/glightbox.min.js') }}"></script>
   
    <!-- Customscript js -->
    <!-- <script src="{{ url('assets/js/script.js') }}"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   

    <!-- Form- Validation  -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="{{ url('public/assets/web/js/form-validation/jquery.validate.js') }}"></script>
    <script src="{{ url('public/assets/web/js/form-validation/additional-methods.min.js') }}"></script>
    <script>

jQuery.validator.addMethod("noSpace", function(value, element) { 
    return value == '' || value.trim().length != 0;
}, "{{__('messages.no_space')}}");

// jQuery.validator.addMethod("validMobile", function(value, element) {
//     console.log(value);
//     return (!/^\d{8}$|^\d{10}$/.test(value) || value == '0000000000') ? false : true;
// },"{{__('messages.valid_mobile')}}");

jQuery.validator.addMethod("ValidPassword", function(value, element) {
    return this.optional(element) || /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@=*$#%]).*$/i.test(value);
}, "{{__('messages.valid_password')}}");
</script>

