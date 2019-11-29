$(document).ready(function () {
    var path = window.location.pathname;
    var page = path.split("/").pop();

    // when the user clicks on the fave button
    $('.fave').on('click', function () {
      var carid = $(this).data('id');
      $car = $(this);

      $.ajax({
        url: page,
        type: 'post',
        data: {
          'fave': 1,
          'car_id': carid
        },
        success: function (response) {
          $car.addClass('hidden');
          $car.siblings().removeClass('hidden');
        }
      });
    });

    // when the user clicks on unfave
    $('.unfave').on('click', function () {
      var carid = $(this).data('id');
      $car = $(this);

      $.ajax({
        url: page,
        type: 'post',
        data: {
          'unfave': 1,
          'car_id': carid
        },
        success: function (response) {
          $car.addClass('hidden');
          $car.siblings().removeClass('hidden');
        }
      });
    });
  });