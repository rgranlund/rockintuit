jQuery(document).ready(function ($) {
  /*
  $("#calculate-btn").click(function () {
    $("html, body").animate(
      { scrollTop: $("#ajaxcalculatorform").offset().top - 50 },
      "slow"
    );
  });
  */

  $("input:radio[name=i-130]").change(function () {
    if ($("input[name='i-130']:checked").val() == "Yes") {
      $("#b").show();
      $("#c").show();
      $("#d").hide();
      $("#p1").hide();
      $("#p2").hide();
      $("#p3").show();
      $("#i1").hide();
      $("#i2").hide();
    }
    if ($("input[name='i-130']:checked").val() == "No") {
      $("#b").hide();
      $("#c").hide();
      $("#d").show();
      $("#p3").hide();
    }
  });

  var cat = "";
  $("#citizen_cat").change(function () {
    cat = $("#citizen_cat option:selected").val();
    if (cat == "IDK") {
      $("#d").show();
    } else {
      $("#d").hide();
    }
  });
  $("input:radio[name=petitioner]").change(function () {
    if ($("input[name='petitioner']:checked").val() == "Petitioner") {
      $("#p1").show();
      $("#p2").show();
      $("#p3").show();
    } else {
      $("#p1").hide();
      $("#p2").hide();
    }
    if ($("input[name='petitioner']:checked").val() == "Intending Immegrant") {
      $("#b").hide();
      $("#c").hide();
      $("#i1").show();
      $("#i2").show();
      $("#p3").show();
    } else {
      $("#i1").hide();
      $("#i2").hide();
      $("#i3").hide();
    }
  });

  //  Clear select values on change
  $("#citizen_cat").change(function () {
    $("#intend_relation").val("");
    $("#relationpet").val("");
  });

  $("#intend_relation").change(function () {
    $("#citizen_cat").val("");
    $("#relationpet").val("");
  });
  $("#relationpet").change(function () {
    $("#citizen_cat").val("");
    $("#intend_relation").val("");
  });
  //  END Clear select values on change

  $("#ajaxcalculatorform").on("submit", function (event) {
    event.preventDefault();
    console.log("AJAX Form Submitted");
    var form = $(this);
    //var ajaxurl = form.data("url");
    var detail_info = {
      ionethirty: form.find(".i-130[name='i-130']:checked").val(),
      citizen_date: form.find("#citizen_date").val(),
      intend_relation: form.find("#intend_relation").val(),
      citizen_cat: form.find("#citizen_cat :selected").val(),
      petitioner: form.find(".petitioner[name='petitioner']:checked").val(),
      perm_res: form.find(".perm-res[name='citizen']:checked").val(),
      citizen_pet: form.find(".citizen-pet[name='citizen_pet']:checked").val(),
      from: form.find("#img_from").val(),
      relation_to_pet: form.find("#relationpet :selected").val(),
    };

    //  ERRORS
    console.log("I-130 Pre Error Function: " + detail_info.ionethirty);
    if (typeof detail_info.ionethirty === "undefined") {
      console.log("I-130: " + detail_info.ionethirty);
      alert('"Have you filed Form I-130?"\n \nField cannot be blank');
      return;
    }
    console.log("FROM: " + detail_info.from);
    console.log("DATE: " + detail_info.citizen_date);

    if (detail_info.ionethirty === "Yes") {
      if (detail_info.citizen_date === "") {
        alert('"Priority Date" - Field cannot be blank');
        return;
      }
      if (detail_info.citizen_cat === "") {
        if (cat != "IDK") {
          alert(
            '"What is the intending immigrant\'s category?" - Field cannot be blank'
          );
          return;
        }
      }
      if (detail_info.from === "") {
        alert(
          '"Where are you or the intending immigrant currently a citizen or national?" - Field cannot be blank'
        );
        return;
      }
    } else {
      if (typeof detail_info.petitioner === "undefined") {
        alert(
          '"Are you the petitioner or the intending immigrant?" - Field cannot be blank'
        );
        return;
      }
      if (detail_info.petitioner === "Petitioner") {
        if (detail_info.perm_res === "") {
          alert('"What is your status?" - Field cannot be blank');
          return;
        }
        if (detail_info.intend_relation === "") {
          alert(
            '"How is the intending immigrant related to you?" - Field cannot be blank'
          );
          return;
        }
      }
      if (detail_info.petitioner === "Intending Immigrant") {
        if (detail_info.citizen_pet === "") {
          alert('"What is the petitioner\'s status?" - Field cannot be blank');
          return;
        }
        if (detail_info.relationpet === "") {
          alert(
            '"How are you related to the petitioner?" - Field cannot be blank'
          );
          return;
        }
      }
    }
    if (detail_info.from === "") {
      alert(
        '"Where are you or the intending immigrant currently a citizen or national?" - Field cannot be blank'
      );
      return;
    }

    //  END ERRORS

    $.ajax({
      url: greencardajax.ajaxurl,
      type: "POST",
      data: {
        post_details: detail_info,
        action: "form_action", // this is going to be used inside function below
      },
      beforeSend: function () {
        // Show image container
        $(".loading-modal").show();
      },

      success: function (data) {
        $("#ajaxcalculator-response").html(data);
        //$("#ajaxcalculatorform")[0].reset();
        return true;
      },
      complete: function (data) {
        // Hide image container
        $(".loading-modal").hide();
      },
      error: function (error) {
        $("#ajaxcalculator-response").html("Error ! : " + error);
        console.log(error);
        return false;
      },
    });
  });
});
