import React, { useState } from 'react';
import 'core-js/es/object/keys';
import 'core-js/es/array/filter';

const Login = () => {
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Ici, tu enverras les données du formulaire à ton API Symfony pour le login
    console.log('Envoi du formulaire de login :', formData);
    // Ajoute l'appel à l'API Symfony ici
  };

  return (
    <div>
      <h2>Connexion</h2>
      <form onSubmit={handleSubmit}>
        <label>
          Email:
          <input
            type="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
          />
        </label>
        <br />
        <label>
          Mot de passe:
          <input
            type="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
          />
        </label>
        <br />
        <button type="submit">Se connecter</button>
      </form>
    </div>
  );
};

export default Login;
