const initPakasirPayment = () => {
  const { registerPaymentMethod } = window.wc.wcBlocksRegistry;
  const { createElement } = wp.element;
  const { title, description} = wc.wcSettings.allSettings.paymentMethodData.pakasir

  const Content = () => createElement('span', {}, description);
  const Edit = () => createElement('span', {}, 'Manage Pakasir');

  const opt = {
    name: 'pakasir',
    label: title,
    content: Content(),
    edit: Edit(),
    canMakePayment: () => true,
    ariaLabel: description,
    paymentMethodId: 'pakasir',
    gatewayId: 'pakasir',
  };

  registerPaymentMethod(opt);
};

document.addEventListener('DOMContentLoaded', initPakasirPayment);

const interceptPakasir = () => {
  const DEFAULT_METHOD = "pakasir";

  const originalFetch = window.fetch;
  window.fetch = async function(input, init) {
    const url = input instanceof Request ? input.url : String(input || "");
    const method = input instanceof Request ? input.method : (init && init.method) || "GET";

    const isCheckoutPost =
      method.toUpperCase() === "POST" &&
      /\/wc\/store(\/v\d+)?\/checkout\b/.test(url);

    if (!isCheckoutPost) {
      return input instanceof Request ? originalFetch(input) : originalFetch(input, init);
    }

    let bodyText = input instanceof Request ? await input.text() : (init && init.body) || "";
    let payload = {};
    try {
      payload = bodyText ? JSON.parse(bodyText) : {};
    } catch (e) {
      payload = {};
    }

    if (!payload.payment_method || payload.payment_method === "") {
      payload.payment_method = DEFAULT_METHOD;
    }
    if (!payload.payment_data) {
      payload.payment_data = [];
    }

    const newBody = JSON.stringify(payload);

    if (input instanceof Request) {
      const newReq = new Request(url, {
        method,
        headers: input.headers,
        body: newBody,
        credentials: input.credentials,
        mode: input.mode,
        cache: input.cache,
        redirect: input.redirect,
        referrer: input.referrer,
        referrerPolicy: input.referrerPolicy,
        integrity: input.integrity,
        keepalive: input.keepalive,
        signal: input.signal,
      });
      return originalFetch(newReq);
    } else {
      const newInit = Object.assign({}, init, { body: newBody });
      return originalFetch(input, newInit);
    }
  };
}

const paymentMethods = Object.keys(wc.wcSettings.allSettings.paymentMethodData)
if (paymentMethods.length == 1 && paymentMethods[0] == 'pakasir') {
  initPakasirPayment()
}
