import { useState } from "react";
import Btn from "../components/btn";
import TextField from "../components/textField";
import ax from "../api/api";
import { useNavigate } from "react-router-dom";
import toast from "react-hot-toast";

function Login() {
  // state hook to disable the login button while the login request is being processed
  const [isClicked, setIsClicked] = useState<boolean>(false);

  // hook to navigate to the dashboard page after successful login
  const navigate = useNavigate();

  // state hook to store the user input for username and password
  const [userInput, setUserInput] = useState({
    username: "",
    password: "",
  });

  const LogUserIn = async (e: React.FormEvent) => {
    // prevent the default form submission behavior and page reload
    e.preventDefault();
    try {
      // make the login button unclickable
      setIsClicked(true);
      // send a request to the backend to authenticate user
      const auth = await ax.post("/auth/login", userInput, {
        headers: { "Content-Type": "application/json" },
      });
      // store the access token and refresh token in local storage for future authenticated requests
      const { accessToken, refreshToken } = auth.data;

      // store the tokens in local storage
      localStorage.setItem("token", accessToken);
      localStorage.setItem("refreshToken", refreshToken);

      // go to the products page after login and
      navigate("/dashboard/products");

      // show a welcome message with the user's first name
      toast(`Welcome in ${auth.data.firstName}`, {
        icon: "👋",
      });
    } catch (err) {
      // if an error happens print i console an dshow error message to the user
      console.error(err);
      toast.error("Something went wrong. Please try again.");
    } finally {
      // make the login button clickable again
      setIsClicked(false);
    }
  };

  // update the input value as rhe user types in the username and password fields
  const onUserTyping = (e: React.ChangeEvent<HTMLInputElement>) => {
    setUserInput({
      ...userInput, //allow the other properties of the userInput state to remain unchanged when user changes one of the input fields
      [e.target.name]: e.target.value,
    });
  };

  return (
    <div className="w-full h-screen relative flex items-center justify-center p-4 flex-col gap-6">
      {/* blurry bg image */}
      <img
        src="../assets/nasr-city-shopping-cairo_16by9.webp"
        className="blur-xs absolute inset-0 w-full h-full object-cover"
      />

      {/* website title */}
      <h1 className="z-10 m-4 uppercase text-white font-bold text-4xl">
        One Glance System
      </h1>

      {/* login form with a bg image */}
      <div className="relative z-20 bg-[url(../assets/nasr-city-shopping-cairo_16by9.webp)] bg-cover bg-center flex flex-col md:flex-row rounded-lg shadow-xl overflow-hidden w-full max-w-md md:max-w-4xl">
        {/* title and subrtitle */}
        <div className="w-full md:w-1/2 text-white text-center flex justify-center flex-col py-8 px-8 bg-black/20">
          <h1 className="font-bold text-2xl">welcome Back</h1>
          <h4 className="font-light">good to see you again</h4>
        </div>

        {/* login form */}
        <form className="w-full md:w-1/2 flex flex-col gap-4 p-8 bg-opacity-20">
          {/* username */}
          <TextField
            value={userInput.username}
            textColor="white"
            label="username"
            icon="../assets/e-mail.svg"
            type="text"
            id="usernameTextField"
            name="username"
            onChange={onUserTyping}
          />

          {/* password */}
          <TextField
            value={userInput.password}
            textColor="white"
            label="password"
            icon="../assets/pass.svg"
            type="password"
            id="passwordTextField"
            name="password"
            onChange={onUserTyping}
          />

          {/* login button */}
          <Btn
            label="login"
            color="bg-btn-orange"
            whenClicked={LogUserIn}
            disable={isClicked}
          />
        </form>
      </div>
    </div>
  );
}

export default Login;
