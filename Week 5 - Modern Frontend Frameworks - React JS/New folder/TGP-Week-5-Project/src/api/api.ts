import axios, { AxiosError, type AxiosRequestConfig } from "axios";
import { refreshTokenRequest } from "./auth";

//create an axios copy with default settings needed for the project
const ax = axios.create({
  baseURL: "https://dummyjson.com", //theurl that all reqs start with
  headers: { "Content-Type": "application/json" }, // make all reqs use json
  withCredentials: false, //don't include cookies
});

//manusally create a property to flag requests that already failed once
interface RetryableRequestConfig extends AxiosRequestConfig {
  _retry?: boolean;
}

//define what a failed/waiting req look like
interface FailedQueueItem {
  resolve: (token: string | null) => void; //sucsess function
  reject: (error: unknown) => void; // fail function
}

//a flag to cjeck if the token is being refreshed rn
let isRefreshing = false;

//array to put any reqs that fail while token is being refreshed
let failedQueue: FailedQueueItem[] = [];

//function to process the waiting reqs from above
const processQueue = (error: unknown, token: string | null = null) => {
  //loop through the reqs
  failedQueue.forEach((prom) => {
    //if the token refresh failed fail all the waiting reqs
    if (error) {
      prom.reject(error);
      //if the token did'nt fail give it to the reqs in order for them to continue
    } else {
      prom.resolve(token);
    }
  });
  // clear the array after dealing with the reqs
  failedQueue = [];
};

ax.interceptors.request.use(
  (config) => {
    // get tokrn fron local storage
    const token = localStorage.getItem("token");

    // if token is found add it to the headers
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    //xontibue the req
    return config;
  },
  //fail the req if an error accure
  (error) => Promise.reject(error)
);

ax.interceptors.response.use(
  //if nothing goes wrong pass the data
  (response) => response,

  // if something goes wrong rub this function
  async (error: AxiosError) => {
    // get the sitting of the failed req
    const originalRequest = error.config as RetryableRequestConfig;

    //error is 401 and not tretrying the req
    if (error.response?.status === 401 && !originalRequest._retry) {
      //if a token refresh is happining stop the req and add it to the witing list
      if (isRefreshing) {
        return (
          new Promise<string | null>((resolve, reject) => {
            failedQueue.push({ resolve, reject });
          })
            // after grtting the new token add it to t the req
            .then((newToken) => {
              if (originalRequest.headers && newToken) {
                originalRequest.headers.Authorization = `Bearer ${newToken}`;
              }
              //try the req agaon
              return ax(originalRequest);
            })
            //if error stop the req
            .catch((err) => Promise.reject(err))
        );
      }

      //   req faiks and a refresh is not hapeninig => this is the first fail => must start the refresh process
      originalRequest._retry = true; // the request is getting retruied mark it to avoid repeat
      isRefreshing = true; // mark the start of the token refresh process

      try {
        // get a new token
        const newToken = await refreshTokenRequest();

        // save new token in local storage
        localStorage.setItem("token", newToken);

        // give new token to the reqs in the wait list
        processQueue(null, newToken);

        // mark the refreshing process as done
        isRefreshing = false;

        // give this first failed req the new tokwn and update the header
        if (originalRequest.headers) {
          originalRequest.headers.Authorization = `Bearer ${newToken}`;
        }

        //retry the first failed req and return the result
        return ax(originalRequest);
      } catch (err) {
        //something is wrong with the token itself

        //fail the waiting regs and stop the refreshing mark
        processQueue(err, null);
        isRefreshing = false;

        //delete bad token from storage
        localStorage.removeItem("token");
        localStorage.removeItem("refreshToken");

        //browser goes to the / page
        window.location.href = "/";
        //return null to segnify error
        return Promise.reject(err);
      }
    }

    //pass the error if none of above applies
    return Promise.reject(error);
  }
);

// export axios instance
export default ax;
