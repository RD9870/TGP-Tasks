// asks the api for a new token

import axios from "axios"; //to make http reqs

//async function that promise to return a string
export async function refreshTokenRequest(): Promise<string> {
  //get refresh token from the browser loc storage if it's there (it was put there the first time the user logged in)
  const refreshToken = localStorage.getItem("refreshToken");
  //if theres no token show error and stop
  if (!refreshToken) {
    throw new Error("no token avaliable");
  }
  //send a post req to the server
  const response = await axios.post(
    "https://dummyjson.com/auth/refresh",
    { refreshToken },
    { headers: { "Content-Type": "application/json" } }
  );

  return response.data.accessToken;
}
