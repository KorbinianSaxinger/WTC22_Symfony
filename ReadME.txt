Dies ist mein Erstes Symfony Projekt. :)
Es besteht aus den unterseiten /hamburg und /berlin, die im ConferenceController zu finden sind.
Auf jeder Seite ist der DB-Eintrag von je einer WTC in der jeweiligen Stadt und 2 passenden Kommentaren zu sehen (Werden mehr wenn mehr in DB).
Die Entitys (Conference.php und Comment.php) Sind mit einer OneToMany relation verbunden (Column: Conference_id)
In der DB ist der standard Benutzer (root:root) benutzt worden.

Die DB "wtcsym"(leer)  habe ich hinzugefügt, kann aber auch selber erstellt werden da sie erst durch die Migrationen gefüllt wird.

WICHTIG
Die Anzeige ist noch sehr hässlich (ganz normale DB ausgabe mit dd()). Aber bevor ich mir um Optik gedanken mache,
möchte ich eine Eingabe für neue Kommentare schreiben. dies muss ich mir jetzt erst einmal vom WWW beibringen lassen.
