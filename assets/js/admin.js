jQuery(document).ready(function ($) {
    /**
     * Adds a new payment gateway row.
     */
    function addRow() {
        var index = $('#wc-cpgm-rows tr').length;
        var row = '<tr class="wc-cpgm-row">' +
            '<td><input type="checkbox" name="gateways[' + index + '][enabled]" value="yes"></td>' +
            '<td><input type="text" name="gateways[' + index + '][name]" value="" required></td>' +
            '<td><textarea name="gateways[' + index + '][description]" rows="3" required></textarea></td>' +
            '<td><button type="button" class="button wc-cpgm-add-row">+</button></td>' +
            '</tr>';
        $('#wc-cpgm-rows').append(row);
    }

    // Delegate the click event for all current and future add buttons.
    $('#wc-cpgm-rows').on('click', '.wc-cpgm-add-row', function (e) {
        e.preventDefault();
        addRow();
    });
});
