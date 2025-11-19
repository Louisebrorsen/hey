<main>
  <!-- HERO -->
  <section class="hero">
    <div class="container hero__wrap">
      <div>
        <h1>Oplev magien på det store lærred</h1>
        <p>
          Book billetter til de nyeste blockbusters og tidløse klassikere.
          En simpel og hurtig oplevelse – på alle enheder.
        </p>
        <div class="hero__actions">
          <a class="btn btn--primary" href="#today">Se dagens forestillinger</a>
          <a class="btn btn--ghost" href="#showing">Udforsk film</a>
        </div>
      </div>
      <div class="hero__poster" aria-hidden="true"></div>
    </div>
  </section>

  <!-- I BIOGRAFEN NU (tom struktur) -->
  <section id="showing">
    <div class="container">
      <div class="section__head">
        <div>
          <h2 class="section__title">I biografen nu</h2>
          <p class="section__sub">Aktuelle titler du kan se i denne uge</p>
        </div>
        <a class="btn btn--ghost" href="#">Alle film</a>
      </div>

      <div class="grid">
        <?php foreach ($nowPlaying as $np): ?>
        <article class="card">
          <?php if (!empty($np['poster_url'])): ?>
            <img class="card__media" src="<?= e($np['poster_url']) ?>" alt="Plakat for <?= e($np['title']) ?>">
          <?php else: ?>
            <div class="card__media" aria-hidden="true"></div>
          <?php endif; ?>

          <div class="card__body">
            <span class="badge">
              <?= e($np['duration_min']) ?> min · <?= e($np['age_limit']) ?>+
            </span>
            <div class="title"><?= e($np['title']) ?></div>
            <div class="meta">
              <?= !empty($np['released']) ? e(date('d.m.Y', strtotime($np['released']))) : 'Ukendt premieredato' ?>
            </div>
          </div>

          <div class="card__actions">
            <a class="btn btn--primary" href="#today">Billetter</a>
            <a class="btn btn--ghost" href="#">Detaljer</a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- DAGENS FORESTILLINGER (tom struktur) -->
  <section id="today">
    <div class="container">
      <div class="section__head">
        <div>
          <h2 class="section__title">Dagens forestillinger</h2>
          <p class="section__sub">Vælg tidspunkt og reserver pladser</p>
        </div>
        <a class="btn btn--ghost" href="#">Hele ugeplanen</a>
      </div>

      <div class="list" role="list">
        <!-- Rækker med dagens forestillinger kommer her senere -->
      </div>

      <div class="cta">
        <div>
          <div class="title">Klar til at booke?</div>
          <div class="muted small">
            Vælg en forestilling ovenfor og fortsæt til sædevalg.
          </div>
        </div>
        <a class="btn btn--primary" href="#">Gå til booking</a>
      </div>
    </div>
  </section>

  <!-- KOMMENDE FILM (tom struktur) -->
  <section id="coming">
    <div class="container">
      <div class="section__head">
        <div>
          <h2 class="section__title">Kommende film</h2>
          <p class="section__sub">Forpremierer og næste måneds highlights</p>
        </div>
        <a class="btn btn--ghost" href="#">Se kalender</a>
      </div>

      <div class="grid">
        <?php foreach ($comingSoon as $cs): ?>
        <article class="card">
          <?php if (!empty($cs['poster_url'])): ?>
            <img class="card__media" src="<?= e($cs['poster_url']) ?>" alt="Plakat for <?= e($cs['title']) ?>">
          <?php else: ?>
            <div class="card__media" aria-hidden="true"></div>
          <?php endif; ?>

          <div class="card__body">
            <span class="badge">
              <?= e($cs['duration_min']) ?> min · <?= e($cs['age_limit']) ?>+
            </span>
            <div class="title"><?= e($cs['title']) ?></div>
            <div class="meta">
              <?= !empty($cs['released']) ? e(date('d.m.Y', strtotime($cs['released']))) : 'Ukendt premieredato' ?>
            </div>
          </div>

          <div class="card__actions">
            <a class="btn btn--primary" href="#today">Billetter</a>
            <a class="btn btn--ghost" href="#">Detaljer</a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- KONTAKT -->
  <section id="contact">
    <div class="contact__container">
      <h1>Kontakt os</h1>
      <p class="contact__intro">
        Har du spørgsmål til vores forestillinger, billetter eller arrangementer?
        Udfyld formularen nedenfor, så vender vi tilbage hurtigst muligt.
      </p>

      <?php if (!empty($_SESSION['contact_success'])): ?>
        <div class="contact_success">
          <?= e($_SESSION['contact_success']) ?>
        </div>
      <?php unset($_SESSION['contact_success']); endif; ?>

      <?php if (!empty($_SESSION['contact_error'])): ?>
        <div class="contact_error">
          <?= e($_SESSION['contact_error']) ?>
        </div>
      <?php unset($_SESSION['contact_error']); endif; ?>

      <form action="contact/send" method="POST" class="contact__form">
        <div class="form__group">
          <label for="name">Navn</label>
          <input type="text" id="name" name="name" placeholder="Dit fulde navn" required>
        </div>

        <div class="form__group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="din@email.dk" required>
        </div>

        <div class="form__group">
          <label for="subject">Emne</label>
          <input type="text" id="subject" name="subject" placeholder="Hvad drejer henvendelsen sig om?" required>
        </div>

        <div class="form__group">
          <label for="message">Besked</label>
          <textarea id="message" name="message" rows="5" placeholder="Skriv din besked her..." required></textarea>
        </div>

        <div class="hp">
          <label for="fax">faxnummer</label>
          <input type="text" id="fax" name="fax" placeholder="Dit faxnummer">
        </div>

        <button type="submit" name="submit" class="btn btn--primary">Send besked</button>
      </form>
    </div>
  </section>
</main>