$(document).ready(function () {
  // Custom email regex validation method
  $.validator.addMethod(
    "emailRegex",
    function (value, element) {
      return this.optional(element) || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },
    "Please enter a valid email address."
  );

  // Apply validation
  $("#contactForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 2,
      },
      phone: {
        required: true,
        digits: true,
        minlength: 10,
        maxlength: 10,
      },
      // email: {
      //   required: true,
      //   emailRegex: true,
      // },
      // message: {
      //   required: true,
      //   minlength: 10,
      // },
    },
    messages: {
      name: "Please enter your name (at least 2 characters)",
      phone: "Enter a valid 10-digit phone number",
      // email: "Enter a valid email address",
      // message: "Message must be at least 10 characters",
    },
    errorClass: "text-red-500 text-sm mt-1",
    errorElement: "p",
    highlight: function (element) {
      $(element).addClass("border-red-500");
    },
    unhighlight: function (element) {
      $(element).removeClass("border-red-500");
    },
    submitHandler: function (form) {
      alert("Form submitted successfully!");

      // Use jQuery to grab form values
      const name = $("#name").val().trim();
      const phone = $("#phone").val().trim();
      const email = $("#email").val().trim();
      const location = $("#location").val().trim();
      const message = $("#message").val().trim();

      // ✅ Example usage: Log to console
      console.log("Name:", name);
      console.log("Phone:", phone);
      console.log("Email:", email);
      console.log("location:", location);
      console.log("Message:", message);

      console.log(form);
      // form.reset();
    },
  });
});
