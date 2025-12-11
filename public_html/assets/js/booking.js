document.addEventListener('DOMContentLoaded', function () {
  const root = document.getElementById('main-content');
  if (!root) return;

  // Læs priser fra data-attributter sat i booking.php
  const ADULT_PRICE  = parseInt(root.dataset.adultPrice, 10)  || 0;
  const CHILD_PRICE  = parseInt(root.dataset.childPrice, 10)  || 0;
  const SENIOR_PRICE = parseInt(root.dataset.seniorPrice, 10) || 0;

  const adultSelect   = document.getElementById('qty_adult');
  const childSelect   = document.getElementById('qty_child');
  const seniorSelect  = document.getElementById('qty_senior');

  const adultSummary   = document.getElementById('summary-adults');
  const childSummary   = document.getElementById('summary-children');
  const seniorSummary  = document.getElementById('summary-seniors');
  const totalSummary   = document.getElementById('summary-total');

  if (!adultSelect || !childSelect || !seniorSelect ||
      !adultSummary || !childSummary || !seniorSummary || !totalSummary) {
    // hvis noget mangler, så stopper vi pænt
    return;
  }

  function recalc() {
    const adults   = parseInt(adultSelect.value, 10)   || 0;
    const children = parseInt(childSelect.value, 10)   || 0;
    const seniors  = parseInt(seniorSelect.value, 10)  || 0;

    const total = adults * ADULT_PRICE +
                  children * CHILD_PRICE +
                  seniors * SENIOR_PRICE;

    adultSummary.textContent  = `${adults} x ${ADULT_PRICE} kr.`;
    childSummary.textContent  = `${children} x ${CHILD_PRICE} kr.`;
    seniorSummary.textContent = `${seniors} x ${SENIOR_PRICE} kr.`;
    totalSummary.textContent  = `${total} kr.`;
  }

  adultSelect.addEventListener('change', recalc);
  childSelect.addEventListener('change', recalc);
  seniorSelect.addEventListener('change', recalc);

  // sørg for at UI matcher defaults ved load
  recalc();
});