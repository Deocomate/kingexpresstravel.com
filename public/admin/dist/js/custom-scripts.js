function initializeDateRangePicker(selector) {
    if (typeof moment === 'function' && typeof $.fn.daterangepicker !== 'undefined') {
        const dateRangePicker = $(selector);

        if (!dateRangePicker.length) {
            return;
        }

        const rangeLocale = {
            TODAY: 'Hôm nay',
            YESTERDAY: 'Hôm qua',
            LAST_7_DAYS: '7 ngày qua',
            LAST_30_DAYS: '30 ngày qua',
            THIS_MONTH: 'Tháng này',
            LAST_MONTH: 'Tháng trước',
            APPLY: 'Áp dụng',
            CANCEL: 'Xóa',
            FROM: 'Từ',
            TO: 'Đến',
            CUSTOM: 'Tùy chỉnh',
            MONTHS: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            DAYS_OF_WEEK: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
        };

        dateRangePicker.daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            linkedCalendars: false,
            showDropdowns: true,
            minYear: 2024,
            maxDate: moment(),
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: rangeLocale.CANCEL,
                applyLabel: rangeLocale.APPLY,
                fromLabel: rangeLocale.FROM,
                toLabel: rangeLocale.TO,
                customRangeLabel: rangeLocale.CUSTOM,
                daysOfWeek: rangeLocale.DAYS_OF_WEEK,
                monthNames: rangeLocale.MONTHS,
                firstDay: 1
            },
            ranges: {
                [rangeLocale.TODAY]: [moment(), moment()],
                [rangeLocale.YESTERDAY]: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                [rangeLocale.LAST_7_DAYS]: [moment().subtract(6, 'days'), moment()],
                [rangeLocale.LAST_30_DAYS]: [moment().subtract(29, 'days'), moment()],
                [rangeLocale.THIS_MONTH]: [moment().startOf('month'), moment().endOf('month')],
                [rangeLocale.LAST_MONTH]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        dateRangePicker.on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        dateRangePicker.on('cancel.daterangepicker', function () {
            $(this).val('');
        });

        const initialValue = dateRangePicker.val();
        if (initialValue) {
            const dates = initialValue.split(' - ');
            if (dates.length === 2) {
                dateRangePicker.data('daterangepicker').setStartDate(dates[0]);
                dateRangePicker.data('daterangepicker').setEndDate(dates[1]);
            }
        }
    } else {
        console.error('moment.js or daterangepicker is not loaded.');
    }
}

$(function () {
    initializeDateRangePicker('.date-range-picker');
});
