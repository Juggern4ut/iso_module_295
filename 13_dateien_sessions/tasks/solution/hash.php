<?php
// Aufgabe 5: Hash für das Passwort erzeugen
//
// Den ausgegebenen Hash in data/benutzer.json eintragen.
// Danach diese Datei löschen: Sie enthält das Passwort im Klartext. Wer die
// Dateien zu sehen bekommt (Backup, Git, Kollegen), kennt sonst das Passwort -
// genau das soll der Hash in benutzer.json verhindern.
//
// Jeder Aufruf ergibt einen anderen Hash, weil password_hash() ein zufälliges
// Salt verwendet. Das Salt steht im Hash selbst, darum kann password_verify()
// trotzdem jeden dieser Hashes prüfen.

echo password_hash("sonnenhof", PASSWORD_DEFAULT);
