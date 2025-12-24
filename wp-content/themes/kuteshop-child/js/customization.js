// Theme customization

jQuery(document).ready(function($) {

    // price modal settings
    $('#modal-price-order').on('show.bs.modal', function (event) {
        var orderButton = $(event.relatedTarget); // Button that triggered the modal
        var productName = orderButton.data('product'); // Extract info from data-* attributes

        var modal = $(this);
        modal.find('.modal-body__name').text( productName );
        modal.find('input.price-form__product').val( productName );
    })
});