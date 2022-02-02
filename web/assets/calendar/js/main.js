$(function() {

  // rome(inline_cal, { time: false });


	rome(inline_cal_from, {time: false, inputFormat: 'YYYY-MM-DD', dateValidator: rome.val.beforeEq(inline_cal_to)}).on('data', function (value) {
        hotelbundle_reservation_arrive.value = value;
	});

	rome(inline_cal_to, {time: false, inputFormat: 'YYYY-MM-DD', dateValidator: rome.val.afterEq(inline_cal_from)}).on('data', function (value) {
        hotelbundle_reservation_sort.value = value;
	});


});

