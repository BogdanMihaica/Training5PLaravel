import axios from "axios";

export async function awaitCsrfCookie() {
   await axios.get('/sanctum/csrf-cookie');
}