**Rapport sur le Projet Votons (Site de Vote En Ligne)**

**Points Globaux du Site :**

Le projet a été conçu pour offrir aux utilisateurs une plateforme pratique pour la gestion des scrutins en ligne, en mettant l'accent sur les fonctionnalités suivantes :

**1. Création de Scrutin :**
   - Les utilisateurs ont la possibilité de créer de nouveaux scrutins de manière intuitive. Ils peuvent spécifier le nom du scrutin, les différentes options de vote disponibles, la date limite pour voter, ainsi que l'attribut du nombre de procurations attribuées. Cette fonctionnalité vise à offrir aux créateurs une flexibilité maximale dans la conception de leurs scrutins tout en simplifiant le processus de création.

**2. Participation à un Scrutin :**
   - Les utilisateurs peuvent participer aux scrutins en cours en votant pour l'une des options proposées. Le processus de vote est conçu pour être accessible à tous les utilisateurs, qu'ils soient familiers avec la plateforme ou non. Cette fonctionnalité vise à encourager la participation active de tous les utilisateurs dans le processus de prise de décision.

**3. Consultation des Résultats d'un Scrutin :**
   - Une fois qu'un scrutin est terminé ou que la date limite est atteinte, les résultats sont affichés de manière claire et détaillée. Les utilisateurs peuvent consulter les pourcentages de votes pour chaque option, ainsi que les résultats finaux. Cette fonctionnalité vise à garantir une transparence totale dans le processus de vote et à permettre aux utilisateurs de comprendre les résultats de manière claire et concise.

**4. Modification d'un Scrutin :**
   - Les créateurs de scrutins ont la possibilité de modifier leurs scrutins existants en fonction des besoins. Cela inclut la suppression d'un scrutin qui n'est plus nécessaire ou la mise fin anticipée à un scrutin en cours. Cette fonctionnalité offre aux créateurs un contrôle total sur leurs scrutins et leur permet de réagir rapidement aux changements de circonstances.

En développant ces fonctionnalités, l'objectif principal était de fournir une plateforme complète et conviviale pour la gestion des scrutins en ligne, tout en garantissant une expérience utilisateur optimale à chaque étape du processus.

**Difficultés Rencontrées :**

Malgré la conception réfléchie du système, quelques difficultés ont été rencontrées lors du développement :
   - La gestion des appels AJAX pour les opérations de suppression et de fin de scrutin a demandé une attention particulière pour assurer la synchronisation efficace entre les actions côté client et les modifications des données côté serveur.
   - La visibilité des barres de progression des résultats a été un défi, notamment lorsque le pourcentage de votes était faible. Des ajustements ont été nécessaires pour rendre les résultats clairement lisibles même avec des pourcentages faibles.
   - La gestion des procurations et la comptabilité des procurations ont posé un défi supplémentaire, en particulier lors de la modification des procurations initiales par les créateurs. Des efforts ont été déployés pour garantir une comptabilité précise des votes et éviter toute confusion dans les résultats finaux.
   - La gestion des procurations a posé un défi supplémentaire en raison du besoin de respecter l'anonymat des votants. Initialement, il était prévu que les utilisateurs puissent attribuer des procurations à d'autres utilisateurs, mais cela aurait compromis l'anonymat. Pour résoudre ce problème, j'ai décidé que seul le créateur du scrutin pouvait attribuer des procurations, tout en respectant la limite du nombre total de votants autorisés.

Malgré ces défis, le projet a été mené à bien en fournissant une plateforme fonctionnelle et conviviale pour la gestion des scrutins en ligne.