const PRICES = {
    "X7221-011-01": 3280,
    "X7221-012-01": 3280,
    "X7221-013-01": 3280,
    "X7221-014-01": 4171,
    "X7221-113-01": 4426,
    "X7221-114-01": 4426,
    "X7221-115-01": 4426,
    "X7223-901-01": 9953,
    "X7223-902-01": 22728,
}

const PRODUCT_ID = {
    1: "X7221-011-01",  // x2 classic
    2: "X7221-012-01",  // x2 rose
    3: "X7221-014-01",  // x2 ebony
    4: "X7221-013-01",  // x2 marine
    5: "X7221-113-01",  // x2 black alligator
    6: "X7221-114-01",  // x2 marine alligator
    7: "X7221-115-01",  // x2 rose alligator
    8: "X7223-901-01",  // prime gold
    9: "X7223-902-01",  // elite gold
}

const CLASSIC_ID = "1";
const CLASSIC_ALLIGATOR_ID = "5";
const ELITE_GOLD = "9";

const LEATHER_UUID = 'fa4187e0-5406-013a-cd66-32182c451fca';
const KEY_VARIANT_UUID = 'fa4b8970-5406-013a-3fc3-32182c451fca';
const METAL_VARIANT_UUID = 'fa473810-5406-013a-f88e-32182c451fca';

const LEATHER_GROUP_UUID = {
    BLACK: "cfeef770-a44a-013a-146f-727faf96b557",
    ROSE: "fa44fb50-5406-013a-72c4-32182c451fca",
    MARINE: "fa45e5e0-5406-013a-7c4b-32182c451fca",
}

const KEY_VARIANT_GROUP_UUID = {
    TITANIUM_SLIVER: "fa4dd390-5406-013a-3a46-32182c451fca",
    BLACK_PVD: "fa508290-5406-013a-f95e-32182c451fca",
    GOLD_18K: "fa4bfa10-5406-013a-9dfe-32182c451fca",
}

const METAL_VARIANT_GROUP_UUID = {
    TITANIUM_SLIVER: "fa480590-5406-013a-e82f-32182c451fca",
    BLACK_PVD: "fa496e90-5406-013a-4a4a-32182c451fca",
    GOLD_18K: "4765c910-6192-013a-bf84-12fe7e319541",
}

const LEATHER_BLACK = "BLACK";
const LEATHER_ROSE = "ROSE";
const LEATHER_MARINE = "MARINE";
const LEATHER_ALLIGATOR = "ALLIGATOR";
// Material for key Variant and metal Variant
const GOLD_18K = "GOLD_18K";
const BLACK_PVD = "BLACK_PVD";
const TITANIUM_SLIVER = "TITANIUM_SLIVER";

var initSayduck = new CustomEvent(
    'sayduck.configurator.actions.updateSelectedConfiguration', {
        detail: Object.fromEntries([
            [LEATHER_UUID, LEATHER_GROUP_UUID["BLACK"]],
            [KEY_VARIANT_UUID, KEY_VARIANT_GROUP_UUID["GOLD_18K"]],
            [METAL_VARIANT_UUID, METAL_VARIANT_GROUP_UUID["GOLD_18K"]],
        ]),
        cancelable: true,
    }
);

(function($) {
    $(document).ready(() => {
        $('#leather').val("BLACK");
        $('#metalVariant').val("GOLD_18K");
        $('#keyVariant').val("GOLD_18K");
        document.addEventListener("sayduck.configurator.selectedConfigurationUpdated", (e) => {}, false);

        document.addEventListener('sayduck.viewer.gltf.loaded', (e) => {
            window.dispatchEvent(
                initSayduck
            );
        }, false);
    });

    //use object.fromEntries to create object with props constants
    let payment = {}

    payment.MTOOrderInfo = {
        'leather': LEATHER_BLACK,
        'keyVariant': GOLD_18K,
        'metalVariant': GOLD_18K,
    }

    $('#leather').on('change', (event) => {
        initSayduck = new CustomEvent(
            'sayduck.configurator.actions.updateSelectedConfiguration', {
                detail: Object.fromEntries([
                    [LEATHER_UUID, LEATHER_GROUP_UUID[event.target.value]]
                ]),
                cancelable: true,
            });
        window.dispatchEvent(
            initSayduck
        );
        payment.MTOOrderInfo = {...payment.MTOOrderInfo, 'leather': event.target.value }
    });


    $('#keyVariant').on('change', (event) => {
        initSayduck = new CustomEvent(
            'sayduck.configurator.actions.updateSelectedConfiguration', {
                detail: Object.fromEntries([
                    [KEY_VARIANT_UUID, KEY_VARIANT_GROUP_UUID[event.target.value]]
                ]),
                cancelable: true,
            });
        window.dispatchEvent(
            initSayduck
        );

        payment.MTOOrderInfo = {...payment.MTOOrderInfo, 'keyVariant': event.target.value };
    });

    $('#metalVariant').on('change', (event) => {
        initSayduck = new CustomEvent(
            'sayduck.configurator.actions.updateSelectedConfiguration', {
                detail: Object.fromEntries([
                    [METAL_VARIANT_UUID, METAL_VARIANT_GROUP_UUID[event.target.value]]
                ]),
                cancelable: true,
            });

        window.dispatchEvent(
            initSayduck
        );
        payment.MTOOrderInfo = {...payment.MTOOrderInfo, 'metalVariant': event.target.value }
    });

    window.addEventListener('sayduck.configurator.actions.updateSelectedConfiguration', (e) => {
        e.preventDefault();
    }, false)


    payment.total_cart = 0;
    payment.carts = [];

    const ORDER_PAGE = $("html");

    $(document).ready(function() {
        let currCarts = localStorage.getItem("mto-carts");
        if (currCarts) {
            currCarts = JSON.parse(currCarts)
            for (let i = 0; i < currCarts.length; i++) {
                payment.total_cart += currCarts[i].quantity;
            }
            $('#quantity-order, #quantity-order__mobile').html(payment.total_cart);
            payment.carts = currCarts;
        }
    })

    payment.addToCart = function() {
        let quantity = parseInt($('#js-pdp-quantity').val())
        const elmQuantity = $('#quantity-order, #quantity-order__mobile');
        let needUpdate = false;
        if (payment.total_cart >= 1 || quantity > 1) {
            popupMsg('One handsets per purchase only.')
            return
        }
        if (payment.total_cart < 0 || quantity < 0) {
            $('#js-pdp-quantity').val(1)
            localStorage.removeItem('mto-carts');
            localStorage.removeItem('info');
            return
        }
        for (let i = 0; i < payment.carts.length; i++) {
            const { quantity, ...cartMaterials } = payment.carts[i];
            if (JSON.stringify(cartMaterials) === JSON.stringify(payment.MTOOrderInfo)) {
                payment.carts[i].quantity += 1;
                payment.total_cart += 1;
                needUpdate = true;
            }
        }
        if (needUpdate) {
            localStorage.setItem("mto-carts", JSON.stringify(payment.carts));
            elmQuantity.html(payment.total_cart);
        } else {
            payment.total_cart += quantity;
            const cart = {
                'quantity': quantity,
                ...payment.MTOOrderInfo,
            }
            payment.carts.push(cart);
            elmQuantity.html(payment.total_cart);
            localStorage.setItem("mto-carts", JSON.stringify(payment.carts));
        }
    }

    payment.checkOut = function() {
        if (payment.carts.length === 0) {
            popupMsg('Your cart is empty.')
            return
        }
        localStorage.setItem("mto-carts", JSON.stringify(payment.carts));
        location.href = 'checkout-mto.html';
    }

    payment.goToTheCart = function() {
        if (payment.carts.length >= 1) {
            location.href = 'checkout-mto.html';
        }
    }

})(jQuery);