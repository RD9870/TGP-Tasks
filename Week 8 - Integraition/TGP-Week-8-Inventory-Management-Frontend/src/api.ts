// api.ts
import axios from "axios";

// create an api call variable
const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api", //"http://localhost:8000/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

//use the token stored in the local storage for authorization
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error),
);

// if user has missing invalid or incorrect credentials
// clear the local storage and relocate user to the login page
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      localStorage.clear();
      // Only redirect if user isn't already in the login/home page
      if (
        window.location.pathname !== "/login" &&
        window.location.pathname !== "/"
      ) {
        window.location.href = "/login";
      }
    }
    return Promise.reject(error);
  },
);

export default api;
