import 'dart:io';

import 'package:flutter/foundation.dart';
import 'package:http/http.dart';
import 'package:http/http.dart' as http;
import 'package:saees_cards/helpers/consts.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Api {
  Future<Response> get(String endPoint) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();

    String? token = prefs.getString("token");
    final response = await http.get(
      Uri.parse("$baseUrl$endPoint"),

      headers: {
        "Accept": "application/json",
        // "content-type": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    if (kDebugMode) {
      print("RESPONSE GET : $baseUrl$endPoint");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    return response;
  }

  Future<Response> post(String endPoint, Map body) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString("token");

    final response = await http.post(
      Uri.parse("$baseUrl$endPoint"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",

        // "content-type": "application/json",
      },
      body: body,
    );

    if (kDebugMode) {
      print("RESPONSE POST : $baseUrl$endPoint");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    return response;
  }

  Future<Response> put(String endPoint, Map body) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString("token");

    final response = await http.put(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",

        // "content-type": "application/json",
      },
    );
    if (kDebugMode) {
      print("RESPONSE PUT : $baseUrl$endPoint");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    return response;
  }

  Future<Response> delete(String endPoint, Map body) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString("token");

    final response = await http.delete(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",

        // "content-type": "application/json",
      },
    );

    if (kDebugMode) {
      print("RESPONSE DELETE : $baseUrl$endPoint");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }

    return response;
  }

  // TODO Complete upload Functionality DONE
  Future<bool> uploadImage(File selectedImgae) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var request = http.MultipartRequest(
      'POST',
      Uri.parse("$baseUrl/vendor/uploader"),
    );
    String? token = prefs.getString("token");

    request.headers.addAll({
      "Accept": "application/json",
      "Authorization": "Bearer $token",
    });
    request.files.add(
      await http.MultipartFile.fromPath('file', selectedImgae.path),
    );

    var response = await request.send();
    var responsetxt = await http.Response.fromStream(response);
    debugPrint("Upload Response: ${responsetxt.body}");
    debugPrint("Response Code: ${response.statusCode}");
    if (response.statusCode == 200) {
      return true;
    } else {
      return false;
    }
  }
}
