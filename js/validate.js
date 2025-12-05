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
      const name = $("#name").val().trim();
      const phone = $("#phone").val().trim();
      const email = $("#email").val().trim();
      const location = $("#location").val().trim(); // optional
      const message = $("#message").val().trim();

      $.ajax({
        type: "POST",
        url: "send.php", // ✅ ensure correct path
        data: {
          name: name,
          phone: phone,
          email: email,
          location: location,
          message: message,
        },
        beforeSend: function () {
          // Optionally show a loading indicator
          $("#submitBtn").prop("disabled", true).text("Sending...");
        },
        success: function (response) {
          if (response.trim() === "success") {
            form.reset();

            // Show thank you popup
            showThankYouModal();
            // Auto-close
            setTimeout(() => {
              hideThankYouModal();
            }, 5000);
          } else {
            alert("Something went wrong: " + response);
          }
        },
        error: function (xhr, status, error) {
          alert("AJAX error: " + error);
        },
        complete: function () {
          $("#submitBtn").prop("disabled", false).text("Submit");
        },
      });
    },
  });
});

function showThankYouModal() {
  $("#thankYouModal").removeClass("hidden");
  $("#thankYouBox")
    .removeClass("opacity-0 scale-95")
    .addClass("opacity-100 scale-100");
}

function hideThankYouModal() {
  // Animate out
  $("#thankYouBox")
    .removeClass("opacity-100 scale-100")
    .addClass("opacity-0 scale-95");

  // Wait for animation to finish before hiding
  setTimeout(() => {
    $("#thankYouModal").addClass("hidden");
  }, 300); // match transition duration
}

// Open modal
// showThankYouModal();

// Auto-close
setTimeout(() => {
  hideThankYouModal();
}, 5000);

// Manual close
$("#closeThankYou").click(function () {
  hideThankYouModal();
});
