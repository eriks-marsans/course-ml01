define([
    'uiComponent',
    'ko',
], function(Component, ko) {
    "use strict";

    var component = Component.extend({
        quantity: ko.observable(1),
        increment: function() {
            var quantity = Number(this.quantity());
            var updatedQuantity = quantity + 1;

            this.quantity(updatedQuantity);
        },
        decrement: function() {
            var quantity = Number(this.quantity());
            var updatedQuantity = quantity - 1;

            this.quantity(updatedQuantity);
        },
    });

    return component;
});
