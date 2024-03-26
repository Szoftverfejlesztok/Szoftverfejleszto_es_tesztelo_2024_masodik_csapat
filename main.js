$(document).ready(function () {
  $('.navbar-nav li').click(function (x) {
    $('.navbar-nav li').removeClass('active');
    $(event.target).parent().addClass('active');
  });
});

  function openPopup() {
    document.getElementById('popup-dialog').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup-dialog').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('nextDatePopUp').addEventListener('click', openPopup);
});

