import React, { useState } from 'react';
import 'core-js/es/object/keys';
import 'core-js/es/array/filter';

const Register = () => {
  const [formData, setFormData] = useState({
    username: '',
    email: '',
    password: '',
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Ici, tu enverras les données du formulaire à ton API Symfony pour l'inscription
    console.log('Envoi du formulaire :', formData);
    // Ajoute l'appel à l'API Symfony ici
  };

  return (
    <div>
      <h2>Inscription</h2>
      <form onSubmit={handleSubmit}>
        <label>
          Nom d'utilisateur:
          <input
            type="text"
            name="username"
            value={formData.username}
            onChange={handleChange}
          />
        </label>
        <br />
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
        <button type="submit">S'inscrire</button>
      </form>
    </div>
  );
};

export default Register;