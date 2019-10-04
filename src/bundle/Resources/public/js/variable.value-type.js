(function(global, doc) {
    // ContextualCode\EzPlatformContentVariablesBundle\Entity\Variable::VALUE_STATIC_PLACEHOLDER
    const placeholder = 'empty-value-placeholder';
    // ContextualCode\EzPlatformContentVariablesBundle\Entity\Variable::VALUE_TYPE_CALLBACK
    const callbackType = 2;

    const handleValueType = (typeSelect) => {
        const container = typeSelect.parentElement.parentElement;
        const staticValue = container.querySelector('.contnet-variable-value-static');
        const callbackValue = container.querySelector('.contnet-variable-value-callback');

        if (parseInt(typeSelect.value) === callbackType) {
            if (staticValue.value === "") {
                staticValue.value = placeholder;
            }
            staticValue.parentElement.hidden = true;
            callbackValue.parentElement.hidden = false;
        } else {
            if (staticValue.value === placeholder) {
                staticValue.value = "";
            }
            staticValue.parentElement.hidden = false;
            callbackValue.parentElement.hidden = true;
        }
    }
    const items = doc.querySelectorAll('.contnet-variable-value-type');

    items.forEach((item) => {
        handleValueType(item);
        item.addEventListener('change', (event) => {
            handleValueType(event.target);
        }, false);
    });
})(window, document);