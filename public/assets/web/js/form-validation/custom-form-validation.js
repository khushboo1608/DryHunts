$(document).ready(function ()
{
    jQuery.validator.addMethod("notEqual", function(value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "Old Password and New Password cannot be same");
});