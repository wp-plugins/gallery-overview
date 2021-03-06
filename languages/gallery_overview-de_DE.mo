��          �       ,      ,  �  -  �  �	     h     t     |     �     �     �     �     �     �  /   �             �   =     �  �   �  �	  �    �     �     �     �     �           &     3     L     h  J   y     �     �  �   �     �   <p><small>In case these options aren't enough for you, you can switch to the shortcode [gallery_overview]. With this <a href="http://codex.wordpress.org/Shortcode_API" title="Shortcode API">shortcode</a> you can place the Gallery Overview on other Post Types and include oder exclude certain Galleries by ID. If you want to use the Shortcode, you might want to set "Add to Page" to blank. Our Shortcode accepts the following parameters:</small></p>
					<small>
						<ul>
							<li><em>all_galleries</em>: List all Galleries (not only from Child Pages). Doesn't accept any Parameters.</li>
							<li><em>pages</em>: Include only Galleries from Pages listed comma-separated by ID. Parameters needed like pages="30,42"</li>
							<li><em>limit</em>: Limit the number of images shown. Parameter needed as integer like limit=5</li>
							<li><em>columns</em>: Set the number of columns. Parameter needed as integer like columns=2</li>
							<li><em>size</em>: Chooses an existing thumbnail size. Parameter needed as string like size="medium"</li>
							<li><em>header</em>: Disables the header, if you want to. Remember to put a link on the gallery. Parameter needed is header=false</li>
							<li><em>before</em>: Simple HTML-Output before any other Gallery-Code. Parameter needed is before="&lt;ul&gt;".</li>
							<li><em>after</em>: Simple HTML-Output after any other Gallery-Code. Parameter needed is after="&lt;/ul&gt;".</li>
							<li><em>layout</em>: Well, now it\s getting kind of tricky. With this attribute you can change the appearance of each gallery. There are 4 variables available: "%linkopen%", "%linkclose%", "%heading%" and "%gallery%". You can pass any HTML you'd like. Example: layout="%linkopen%&lt;h3&gt;%heading%&lt;/h3&gt;%linkclose%" will print you just the heading, wrapped in a link.</li>
							<li><em>link</em>: Let's you choose, what will be wrapped in the link. Available Options are "heading", "gallery" and "both". To be used like link="heading".</li>
						</ul>
					</small>
					<p><small>If you have any ideas on how to improve this Shortcode, just send us an email to <a href="mailto:gallery@antwortzeit.de">gallery@antwortzeit.de</a></small></p> <p>This plugin fixes the one thing that is really wrong with WordPress' Core Gallery:  You don't have an Gallery Overview Page, that lists all your galleries. So now all you have to do is add the Gallery Overview to a page and, if you like, fine tune the settings below to your needs. This plugin uses only WordPress' own code, so you can be sure, that the Gallery Overview will look exactly like your Theme wants it to.</p> Add to Page Columns Gallery Gallery Overview Gallery Overview Settings Heading Heading and Gallery Limit Images to Link to Gallery List all Galleries (Not only from Child Pages)? None Shortcode [gallery_overview] This plugin fixes the one thing that is really wrong with WordPress' Core Gallery:  You don't have an Gallery Overview Page, that lists all your galleries. Well, now you do. Thumbnail Size Project-Id-Version: Gallery Overview v0.1
PO-Revision-Date: 2014-01-22 02:08:19+0000
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Poedit 1.5.4 <p><small>Wenn Dir diese Einstellungen nicht genug sind, kannst du auf den Shortcode [gallery_overview] ausweichen. Mit diesem <a href="http://codex.wordpress.org/Shortcode_API" title="Shortcode API">Shortcode</a> kannst du die Galerie-Übersicht auf anderen Post Types platzieren und Galerien per ID ein- und ausschließen. Wenn du den Shortcode nutzen möchtest, ist es vielleicht besser, wenn du "Zu Seite hinzufügen" leer lässt. Unser Shortcode akzeptiert die folgenden Parameter:</small></p>
					<small>
						<ul>
							<li><em>all_galleries</em>: Listet alle Galerien auf, nicht nur diejenigen von untergeordneten Seiten. Akzeptiert keine Parameter.</li>
							<li><em>pages</em>: Bindet nur Galerien von bestimmten Seiten ein, die mit ihrer ID einer Komma-getrennten Liste übergeben werden. Muss eingegeben werden wie pages="30,42"</li>
							<li><em>limit</em>: Begrenzt die Anzahl der angezeigten Bilder. Muss eingegeben werden wie limit=5</li>
							<li><em>columns</em>: Setzt die Anzahl der angezeigten Spalten. Muss eingegeben werden wie columns=2</li>
							<li><em>size</em>: Wählt eine bereits definierte Bildgröße aus. Muss eingegeben werden wie size="medium"</li>
							<li><em>header</em>: Blendet die Überschrift aus. Du sollest dann vermutlich einen Link auf die Galerie legen, siehe unten. Der erforderliche Parameter ist header=false</li>
							<li><em>before</em>: Gibt einfach HTML-Code vor der gesamten Galerie aus. Der erforderliche Parameter ist wie before="&lt;ul&gt;".</li>
							<li><em>after</em>: Gibt einfach HTML-Code hinter der gesamten Galerie aus. Der erforderliche Parameter ist after="&lt;/ul&gt;".</li>
							<li><em>layout</em>: Tja, jetzt wird es interessant. Mit diesem Parameter kannst du das komplette Layout einer einzelnen Galerie bestimmen. Es gibt die folgenden 4 Variablen: "%linkopen%", "%linkclose%", "%heading%" and "%gallery%". Du kannst jeden HTML-Code eingeben. Zum Beispiel: layout="%linkopen%&lt;h3&gt;%heading%&lt;/h3&gt;%linkclose%". Das gibt dir nur die Überschrift, verpackt in einen Link zur Galerie aus.</li>
							<li><em>link</em>: Lässt dich auswählen, was verlinkt werden soll. Mögliche Einstellungen sind "heading", "gallery" und "both". Wird verwendet wie link="heading".</li>
						</ul>
					</small>
					<p><small>Wenn du Ideen hast, wie wir den Shortcode (oder auch das gesamte Plugin) verbessern könnten, freuen wir uns auf deine E-Mail an <a href="mailto:gallery@antwortzeit.de">gallery@antwortzeit.de</a></small></p> <p>Dieses Plugin behebt die eine große Schwäche der von WordPress mitgebrachten Galerien: Es gibt keine Übersichtsseite, die alle Galerien auflisten kann. Mit diesem Plugin musst du nur die Galerie-Übersicht zu einer Seite hinzufügen und, wenn du möchtest, die Einstellungen weiter unten deinen Bedürfnissen anpassen. Das Plugin gibt die Galerien auf der Übersichtsseite mit WordPress-Bordmitteln aus. Du kannst dir sicher sein, dass auch die Galerie-Übersicht genau so aussieht, wie dein Theme das möchte.</p> Zu Seite hinzufügen Spalten Galerie Galerie-Übersicht Einstellungen Galerie-Übersicht Überschrift Überschrift und Galerie Bildanzahl beschränken auf Link zur Galerie Alle Galerien auflisten (nicht nur diejenigen von untergeordneten Seiten)? Keiner Shortcode [gallery_overview] Dieses Plugin behebt die eine große Schwäche der von WordPress mitgebrachten Galerien: Es gibt keine Übersichtsseite, die alle Galerien auflisten kann. Tja, jetzt gibt es eine. Bildgröße 