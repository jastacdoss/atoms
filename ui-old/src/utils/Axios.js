// Axios.js
// Create axios object for use in project
import axios from 'axios';

// Create axios instance with configurations
const config = {
  headers: {
    'X-Request-With': 'XMLHttpRequest',
  },
  baseURL: '/api',
  withCredentials: true,
};

// Only proxy requests if in development
if (process.env.NODE_ENV === 'development') {
  config.proxy = {
    host: 'http://atoms.test/api',
    port: 80,
  };
}

// Create the axios instance
const client = axios.create(config);

export default client;
