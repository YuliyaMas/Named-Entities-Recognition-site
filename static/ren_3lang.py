import spacy
import sys
import json

# Charger les modèles SpaCy pour les langues spécifiques
nlp_fr = spacy.load("fr_core_news_sm")
nlp_en = spacy.load("en_core_web_sm")
nlp_uk = spacy.load("uk_core_news_sm")  # Modèle multilingue pour l'ukrainien

langue = sys.argv[1]
texte = sys.argv[2]

# Fonction pour effectuer la reconnaissance d'entités nommées en français
def reconnaissance_fr(texte):
    doc = nlp_fr(texte)
    entites = [{"entite": ent.text, "label": ent.label_} for ent in doc.ents]
    return entites

# Fonction pour effectuer la reconnaissance d'entités nommées en anglais
def reconnaissance_en(texte):
    doc = nlp_en(texte)
    entites = [{"entite": ent.text, "label": ent.label_} for ent in doc.ents]
    return entites

# Fonction pour effectuer la reconnaissance d'entités nommées en ukrainien
def reconnaissance_uk(texte):
    doc = nlp_uk(texte)
    entites = [{"entite": ent.text, "label": ent.label_} for ent in doc.ents]
    return entites

# Effectuer la reconnaissance d'entités nommées en fonction de la langue choisie
if langue == 'fr':
    entites = reconnaissance_fr(texte)
    resultat = {"entites": entites}
elif langue == 'en':
    entites = reconnaissance_en(texte)
    resultat = {"entites": entites}
elif langue == 'uk':
    entites = reconnaissance_uk(texte)
    resultat = {"entites": entites}
else:
    resultat = {"erreur": "Langue non supportée"}

# Convertir le résultat en JSON
resultat_json = json.dumps(resultat)

# Retourner le résultat JSON ou le stocker dans une variable
print(resultat_json)
