import axios from "axios";

export async function fetchCsrfCookie() {
   await axios.get('/sanctum/csrf-cookie');
}