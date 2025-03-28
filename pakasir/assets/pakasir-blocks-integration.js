const initPakasirPayment = () => {
  const { registerPaymentMethod } = window.wc.wcBlocksRegistry;
  const { createElement } = wp.element;
  const content = () => createElement('span', {}, 'Bayar dengan Pakasir Payment Gateway.')
  const edit = () => createElement('span', {}, 'Pengaturan Pakasir')
  const opt = {
    name: 'pakasir',
    label: 'Pakasir',
    content: content(),
    edit: edit(),
    canMakePayment: () => true,
    ariaLabel: 'Pakasir Payment Gateway',
    paymentMethodId: 'pakasir',
    gatewayId: 'pakasir',
  }
  registerPaymentMethod(opt);
}

document.addEventListener('DOMContentLoaded', initPakasirPayment);
