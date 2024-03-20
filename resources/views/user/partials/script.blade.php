<script>
    $(document).on('click', '#add-address', function() {
        var addressFieldCount = $('.address-container').length;
    
        function addAddressField() {
            addressFieldCount++;
            var addressField = '<div class="address-container"><textarea name="addresses[]" rows="2" cols="50"></textarea> <button type="button" class="btn btn-sm btn-danger btn-outline-danger w-40 remove-address" data-address-id="' + addressFieldCount + '">Remove</button></div>';
            $('#address-fields').append(addressField);
        }
    
        function removeAddressField(addressId) {
            $('#address_' + addressId).parent().remove();
        }
    
        addAddressField();
    });
    
    $(document).on('click', '.remove-address', function() {
        var addressId = $(this).data('address-id');
        $(this).parent().remove();
    });
</script>