import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:toastification/toastification.dart';
import 'package:top_book_store/helpers/consts.dart';
import 'package:top_book_store/providers/auth_provider.dart';
import 'package:top_book_store/screens/auth_screens/Author_login_screen.dart';
import 'package:top_book_store/widgets/form_field.dart';
import 'package:flutter/foundation.dart';
import 'package:provider/provider.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  TextEditingController userNameCtrl = TextEditingController(
    text: kDebugMode ? "testAuthor" : "",
  );
  TextEditingController nameCtrl = TextEditingController(
    text: kDebugMode ? "Test Author" : "",
  );
  TextEditingController emailCtrl = TextEditingController(
    text: kDebugMode ? "testAuthor@email.com" : "",
  );
  TextEditingController passwordCtrl = TextEditingController(
    text: kDebugMode ? "password" : "",
  );
  TextEditingController countreyCtrl = TextEditingController(
    text: kDebugMode ? "Libya" : "",
  );
  TextEditingController bioCtrl = TextEditingController(
    text: kDebugMode ? "test author bio" : "",
  );
  final GlobalKey<FormState> formKey = GlobalKey<FormState>();
  @override
  Widget build(BuildContext context) {
    return Consumer<AuthProvider>(
      builder: (context, authConsumer, _) {
        return Scaffold(
          body: Stack(
            fit: StackFit.expand,
            children: [
              Image.asset("assets/loginBG.jpg", fit: BoxFit.cover),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Container(
                    margin: const EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: whiteColor.withValues(alpha: 0.8),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Column(
                        children: [
                          Center(
                            child: Text(
                              "WELCOME TO TOP BOOK STORE",
                              style: TextStyle(
                                fontSize: 20,
                                color: primaryColor,
                                fontFamily: GoogleFonts.getFont(
                                  'Knewave',
                                ).fontFamily,
                              ),
                            ),
                          ),
                          Form(
                            key: formKey,
                            child: Column(
                              children: [
                                AuthorFormField(
                                  txt: "userName",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your user name";
                                    }
                                    return null;
                                  },
                                  controller: userNameCtrl,
                                ),
                                AuthorFormField(
                                  txt: "name",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your name";
                                    }
                                    return null;
                                  },
                                  controller: nameCtrl,
                                ),
                                AuthorFormField(
                                  txt: "email",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your email";
                                    }
                                    return null;
                                  },
                                  controller: emailCtrl,
                                ),
                                AuthorFormField(
                                  txt: "password",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your password";
                                    } else if (validate.length < 2) {
                                      return "Password must be at least 2 characters long";
                                    }
                                    return null;
                                  },
                                  controller: passwordCtrl,
                                ),
                                AuthorFormField(
                                  txt: "country",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your country";
                                    }
                                    return null;
                                  },
                                  controller: countreyCtrl,
                                ),
                                AuthorFormField(
                                  isLarge: true,
                                  txt: "Bio",
                                  validate: (validate) {
                                    if (validate == null || validate.isEmpty) {
                                      return "Please enter your bio";
                                    } else if (validate.length < 5) {
                                      return "Bio must be at least 5 characters long";
                                    }
                                    return null;
                                  },
                                  controller: bioCtrl,
                                ),
                              ],
                            ),
                          ),

                          Column(
                            children: [
                              ElevatedButton(
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: primaryColor,
                                  foregroundColor: whiteColor,
                                ),
                                onPressed: authConsumer.busy
                                    ? () {}
                                    : () {
                                        if (formKey.currentState!.validate()) {
                                          authConsumer
                                              .register({
                                                "username": userNameCtrl.text,
                                                "name": nameCtrl.text,
                                                "email": emailCtrl.text,
                                                "password": passwordCtrl.text,
                                                "country": countreyCtrl.text,
                                                "bio": bioCtrl.text,
                                              })
                                              .then((value) {
                                                if (value[0] == true) {
                                                  toastification.show(
                                                    type: ToastificationType
                                                        .success,
                                                    style: ToastificationStyle
                                                        .flatColored,
                                                    title: Text(value[1]),
                                                    autoCloseDuration:
                                                        const Duration(
                                                          seconds: 5,
                                                        ),
                                                  );

                                                  if (!context.mounted) return;

                                                  Navigator.pushReplacement(
                                                    context,
                                                    MaterialPageRoute(
                                                      builder: (context) =>
                                                          const LoginScreen(),
                                                    ),
                                                  );
                                                } else {
                                                  toastification.show(
                                                    type: ToastificationType
                                                        .error,
                                                    style: ToastificationStyle
                                                        .flatColored,
                                                    title: Text(value[1]),
                                                    autoCloseDuration:
                                                        const Duration(
                                                          seconds: 5,
                                                        ),
                                                  );
                                                }
                                              });
                                        }
                                      },
                                child: authConsumer.busy
                                    ? SizedBox(
                                        height: 25,
                                        width: 25,
                                        child: CircularProgressIndicator(
                                          color: whiteColor,
                                        ),
                                      )
                                    : Text("Register as Author"),
                              ),
                              TextButton(
                                onPressed: () {
                                  if (!context.mounted) return;

                                  Navigator.pushReplacement(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => const LoginScreen(),
                                    ),
                                  );
                                },
                                child: Text("Already have an account? Login"),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      },
    );
  }
}
