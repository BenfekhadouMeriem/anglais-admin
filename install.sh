#!/bin/bash

# Créer un environnement virtuel Python
python3 -m venv .venv

# Activer l'environnement virtuel
source .venv/bin/activate

# Installer les dépendances Python
pip install --upgrade pip
pip install -r requirements.txt
