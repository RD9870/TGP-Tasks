import 'package:flutter/foundation.dart';
import 'package:http/http.dart';
import 'package:http/http.dart' as http;
import 'package:tgp_games/helpers/consts.dart';

class API {
  Future<Response> get(String endPoint) async {
    final response = await http.get(Uri.parse("$baseUrl$endPoint"));
    if (kDebugMode) {
      print("RESPONSE GET: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  Future<Response> post(String endPoint, Map body) async {
    final response = await http.post(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
    );
    if (kDebugMode) {
      print("RESPONSE POST: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  Future<Response> put(String endPoint, Map body) async {
    final response = await http.put(Uri.parse("$baseUrl$endPoint"), body: body);
    if (kDebugMode) {
      print("RESPONSE PUT: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }

  Future<Response> delete(String endPoint, Map body) async {
    final response = await http.delete(
      Uri.parse("$baseUrl$endPoint"),
      body: body,
    );
    if (kDebugMode) {
      print("RESPONSE delete: $baseUrl$endPoint");
      print("RESPONSE STATUS CODE: ${response.statusCode}");
      print("RESPONSE BODY: ${response.body}");
    }
    return response;
  }
}
