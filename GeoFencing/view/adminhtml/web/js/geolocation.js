define([
    'jquery',
    'uiComponent'
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            apiKey: '' // This will be populated by the layout XML configuration
        },

        initialize: function () {
            this._super();
            var self = this;

            // Do not proceed if the API key is missing.
            if (!this.apiKey) {
                console.error('AgriCart_GeoFencing: Google API Key is missing. Please configure it in the admin panel.');
                return;
            }

            // Dynamically load the Google Maps script using the API key from the component's configuration.
            // Using requirejs's async loader ensures we don't try to use `google` before it's ready.
            require(['async!https://maps.googleapis.com/maps/api/js?key=' + this.apiKey + '&libraries=places'], function () {
                // Now that the script is loaded, find the input field and initialize autocomplete.
                // We use an interval to make sure the UI component has rendered the field.
                var interval = setInterval(function () {
                    var input = document.querySelector('input[name="product[geo_location]"]');
                    if (input) {
                        clearInterval(interval);
                        self.initAutocomplete(input);
                    }
                }, 500);
            });
        },

        initAutocomplete: function (input) {
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                // Ensure the user selected a valid place from the suggestions.
                if (place.geometry) {
                    var location = place.geometry.location;
                    // Mark the input as validated.
                    input.setAttribute('data-validated', 'true');
                    // Format the value to be saved.
                    input.value = place.name + ' (' + location.lat() + ', ' + location.lng() + ')';
                    // Trigger a change event for Magento's UI component to recognize the new value.
                    $(input).trigger('change');
                } else {
                    input.setAttribute('data-validated', 'false');
                }
            });

            // If the user manually changes the input after selecting a valid place, mark it as unvalidated.
            $(input).on('change', function () {
                if ($(this).attr('data-validated') !== 'true') {
                    // Logic to handle un-validated input if needed, e.g., clear the field or show a warning.
                }
                // Reset the validation status on any manual change.
                $(this).attr('data-validated', 'false');
            });
        }
    });
});
