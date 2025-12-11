document.addEventListener('DOMContentLoaded', function () {
  const root = document.getElementById('main-content');
  if (!root) return;

  // Priser fra data-attributter (sat i booking.php)
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

  const seatInputs   = document.querySelectorAll('input[name="seats[]"]');
  const seatCounter  = document.getElementById('seat-counter');
  const confirmBtn   = document.querySelector('.btn2');

  if (!adultSelect || !childSelect || !seniorSelect ||
      !adultSummary || !childSummary || !seniorSummary || !totalSummary) {
    return;
  }

  function getCurrentCounts() {
    const adults   = parseInt(adultSelect.value, 10)   || 0;
    const children = parseInt(childSelect.value, 10)   || 0;
    const seniors  = parseInt(seniorSelect.value, 10)  || 0;
    const totalTickets = adults + children + seniors;

    return { adults, children, seniors, totalTickets };
  }

  function recalcPrices() {
    const { adults, children, seniors } = getCurrentCounts();

    const total = adults * ADULT_PRICE +
                  children * CHILD_PRICE +
                  seniors * SENIOR_PRICE;

    adultSummary.textContent  = `${adults} x ${ADULT_PRICE} kr.`;
    childSummary.textContent  = `${children} x ${CHILD_PRICE} kr.`;
    seniorSummary.textContent = `${seniors} x ${SENIOR_PRICE} kr.`;
    totalSummary.textContent  = `${total} kr.`;
  }

  function updateSeatCounter() {
    if (!seatCounter) return;

    const { totalTickets } = getCurrentCounts();
    const selectedSeats = Array.from(seatInputs).filter(input => input.checked).length;

    seatCounter.classList.remove('ok', 'warning', 'error');

    // Default: kræv sæder og disable knap, hvis noget ikke matcher
    let canConfirm = false;

    if (totalTickets === 0) {
      seatCounter.textContent = 'Vælg først antal billetter.';
      seatCounter.classList.add('warning');
    } else if (selectedSeats === 0) {
      seatCounter.textContent = `Du har endnu ikke valgt nogen sæder. Du skal vælge ${totalTickets} i alt.`;
      seatCounter.classList.add('warning');
    } else if (selectedSeats > totalTickets) {
      seatCounter.textContent = `Du har valgt for mange sæder (${selectedSeats} ud af ${totalTickets}). Fjern nogle sæder.`;
      seatCounter.classList.add('error');
    } else if (selectedSeats < totalTickets) {
      const diff = totalTickets - selectedSeats;
      seatCounter.textContent = `Du mangler at vælge ${diff} sæde${diff === 1 ? '' : 'r'} (valgt ${selectedSeats} ud af ${totalTickets}).`;
      seatCounter.classList.add('warning');
    } else {
      seatCounter.textContent = `Du har valgt ${selectedSeats} ud af ${totalTickets} sæder.`;
      seatCounter.classList.add('ok');
      canConfirm = true;
    }

    if (confirmBtn) {
      confirmBtn.disabled = !canConfirm;
    }
  }

  function recalcAll() {
    recalcPrices();
    updateSeatCounter();
  }

  // Lyt på ændringer i billet-antal
  ['change', 'input'].forEach(evt => {
    adultSelect.addEventListener(evt, handleTicketChange);
    childSelect.addEventListener(evt, handleTicketChange);
    seniorSelect.addEventListener(evt, handleTicketChange);
  });

  function handleTicketChange() {
    const { totalTickets } = getCurrentCounts();
    const currentlySelected = Array.from(seatInputs).filter(i => i.checked);
    if (currentlySelected.length > totalTickets) {
      currentlySelected.slice(totalTickets).forEach(i => (i.checked = false));
    }
    recalcAll();
  }

  // Lyt på ændringer i sædevalg og begræns antal
  seatInputs.forEach(input => {
    input.addEventListener('change', function () {
      const { totalTickets } = getCurrentCounts();

      if (this.checked && totalTickets > 0) {
        const selectedSeats = Array.from(seatInputs).filter(i => i.checked).length;
        if (selectedSeats > totalTickets) {
          // For mange sæder → fortryd dette valg
          this.checked = false;
        }
      }

      updateSeatCounter();
    });
  });

  // Initial sync ved load
  recalcAll();
});