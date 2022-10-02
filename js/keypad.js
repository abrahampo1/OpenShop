function KeyPad() {
  $("#keypad .card").each(function (index, element) {
    $(element).on("click", (r) => {
      KeyPadHandler(r.target.innerText);
    });
    $(element).on("touchstart", (r) => {
      $(element).addClass("touching");
    });
    $(element).on("touchend", (r) => {
      $(element).removeClass("touching");
    });
  });
}

let FocusedInput;
function KeyPadHandler(key) {
  if (FocusedInput) {
    if (key != "OK" && key != "C" && key != "AC") {
      if (FocusedInput.innerText == "0" && key != ".") {
        FocusedInput.innerText = "";
      }
      FocusedInput.innerText += key;
    }

    if (key == "OK") {
      FocusedInput = null;
      $("#keypad").fadeOut("fast");
      $(".focused").removeClass("focused");
    }

    if (key == "C") {
      FocusedInput.innerText = FocusedInput.innerText.slice(0, -1);
    }
    if (key == "AC") {
      FocusedInput.innerText = "";
    }
    if (FocusedInput && FocusedInput.innerText == "") {
      FocusedInput.innerText = "0";
    }
  }
}

function KeyPadFocus(inp) {
  $(".focused").removeClass("focused");
  $(inp).addClass("focused");
  FocusedInput = inp;
  $("#keypad").fadeIn("fast");
  $("#keypad").offset({
    top: inp.offsetTop + $(inp).height(),
    left: inp.offsetLeft,
  });
  $("#keypad").attr("data-y", inp.offsetTop + $(inp).height());
  $("#keypad").attr("data-x", inp.offsetLeft);
}

KeyPad();
