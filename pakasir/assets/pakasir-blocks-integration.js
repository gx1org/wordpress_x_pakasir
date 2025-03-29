const initPakasirPayment = () => {
  const { registerPaymentMethod } = window.wc.wcBlocksRegistry;
  const { createElement } = wp.element;
  const content = () => createElement('span', {}, pakasir_checkout_data.description)
  const edit = () => createElement('span', {}, 'Manage Pakasir')
  const opt = {
    name: 'pakasir',
    label: pakasir_checkout_data.title,
    content: content(),
    edit: edit(),
    canMakePayment: () => true,
    ariaLabel: pakasir_checkout_data.description,
    paymentMethodId: 'pakasir',
    gatewayId: 'pakasir',
  }
  registerPaymentMethod(opt);
}

document.addEventListener('DOMContentLoaded', initPakasirPayment);
