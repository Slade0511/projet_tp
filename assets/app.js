import { registerReactControllerComponents } from '@symfony/ux-react';
import './bootstrap.js';
import React from 'react';
import ReactDOM  from 'react-dom/client';
import './index.css'
import App from './app' ;


import axios from 'axios';

const data = {
  nom: 'Dupont',
  prenom: 'Jean',
  date_naissance: '1990-02-01',
  genre: 'Masculin',
};

axios.post('http://localhost/8000/api/create-habitant', data)
  .then(response => {
    console.log(response.data.message, data);
  })
  .catch(error => {
    console.error('Erreur lors de la création de l\'habitant :', error.response.data.error);
  });


  const btnCreateHabitant = document.getElementById('btnCreateHabitant');
  if (btnCreateHabitant) {
    btnCreateHabitant.addEventListener('click', handleClick);
  }

const root = ReactDOM.createRoot(
    document.getElementById('root')
);

root.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
)
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));