<?php
?>
<!DOCTYPE html>
<html lang="da">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cinema – Biograf</title>
  <meta name="description" content="Biografbeskrivelse" />
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <header>
    <div class="container nav">
      <a href="/" class="brand" aria-label="Forside">
        <span class="brand__logo" aria-hidden="true"></span>
        <span>Cinema</span>
      </a>

      <nav aria-label="Hovednavigation" class="menu">
        <a href="/">I biografen</a>
        <a href="#today">Dagens forestillinger</a>
        <a href="#coming">Kommende film</a>
        <a href="#contact">Kontakt</a>
        <a href="/login">Login</a>
      </nav>

      <details class="navdrop">
        <summary aria-label="Åbn menu">
          <span class="hamb"><span></span></span>
        </summary>

        <div class="drawer" role="menu">
          <a role="menuitem" href="/">I biografen</a>
          <a role="menuitem" href="#today">Dagens forestillinger</a>
          <a role="menuitem" href="#coming">Kommende film</a>
          <a role="menuitem" href="#contact">Kontakt</a>
          <a role="menuitem" href="/login">Login</a>
        </div>
      </details>
    </div>
  </header>