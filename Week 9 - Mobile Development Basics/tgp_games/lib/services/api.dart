import 'package:flutter/foundation.dart';
import 'package:http/http.dart';
import 'package:http/http.dart' as http;
import 'package:tgp_games/helpers/consts.dart';

class API {
  //send a get request to the baseUrl
  Future<Response> get(String endPoint) async {
    final response = await http.get(Uri.parse("$baseUrl$endPoint"));
    // print useful info in the terminal for debug
    if (kDebugMode) {
      print("RESPONSE GET: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  //send a post request to the baseUrl
  Future<Response> post(String endPoint, Map body) async {
    final response = await http.post(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
    );
    // print useful info in the terminal for debug
    if (kDebugMode) {
      print("RESPONSE POST: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  //send a put request to the baseUrl
  Future<Response> put(String endPoint, Map body) async {
    final response = await http.put(Uri.parse("$baseUrl$endPoint"), body: body);
    // print useful info in the terminal for debug
    if (kDebugMode) {
      print("RESPONSE PUT: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  //send a delete request to the baseUrl
  Future<Response> delete(String endPoint, Map body) async {
    final response = await http.delete(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
    );
    // print useful info in the terminal for debug
    if (kDebugMode) {
      print("RESPONSE delete: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }
}
