Dies ist mein Erstes Symfony Projekt. :)
Es besteht aus den Unterseiten /hamburg und /berlin, die im ConferenceController zu finden sind.
Auf jeder Seite ist der DB-Eintrag von je einer WTC in der jeweiligen Stadt und 2 passenden Kommentaren zu sehen (Werden mehr wenn mehr in DB).
Die Entitys (Conference.php und Comment.php) Sind mit einer OneToMany relation verbunden (Column: Conference_id)
In der DB ist der standard Benutzer (root:root) benutzt worden.

Die DB "wtcsym"(leer)  habe ich hinzugefügt, kann aber auch selber erstellt werden da sie erst durch die Migrationen gefüllt wird.

[Update 15.01.2022]
Das hinzufügen neuer Kommentare geht über /hamburg-comment und /berlin-comment


