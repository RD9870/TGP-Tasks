import 'dart:convert';

// todo TASK 0 ( GOLDEN TASK ) WEB REFACTOR Done?
// from https://quicktype.io/
// define the object expected from the backend
class SingleGameModel {
  int id;
  String title;
  String thumbnail;
  String status;
  String shortDescription;
  String description;
  String gameUrl;
  String genre;
  String platform;
  String publisher;
  String developer;
  DateTime releaseDate;
  String freetogameProfileUrl;
  MinimumSystemRequirements? minimumSystemRequirements;
  List<Screenshot> screenshots;

  SingleGameModel({
    required this.id,
    required this.title,
    required this.thumbnail,
    required this.status,
    required this.shortDescription,
    required this.description,
    required this.gameUrl,
    required this.genre,
    required this.platform,
    required this.publisher,
    required this.developer,
    required this.releaseDate,
    required this.freetogameProfileUrl,
    this.minimumSystemRequirements,
    required this.screenshots,
  });

  factory SingleGameModel.fromRawJson(String str) =>
      SingleGameModel.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory SingleGameModel.fromJson(Map<String, dynamic> json) =>
      SingleGameModel(
        id: json["id"],
        title: json["title"],
        thumbnail: json["thumbnail"],
        status: json["status"],
        shortDescription: json["short_description"],
        description: json["description"],
        gameUrl: json["game_url"],
        genre: json["genre"],
        platform: json["platform"],
        publisher: json["publisher"],
        developer: json["developer"],
        releaseDate: DateTime.parse(json["release_date"]),
        freetogameProfileUrl: json["freetogame_profile_url"],
        minimumSystemRequirements: (json["minimum_system_requirements"] != null)
            ? MinimumSystemRequirements.fromJson(
                json["minimum_system_requirements"],
              )
            : null,
        screenshots: List<Screenshot>.from(
          json["screenshots"].map((x) => Screenshot.fromJson(x)),
        ),
      );

  Map<String, dynamic> toJson() => {
    "id": id,
    "title": title,
    "thumbnail": thumbnail,
    "status": status,
    "short_description": shortDescription,
    "description": description,
    "game_url": gameUrl,
    "genre": genre,
    "platform": platform,
    "publisher": publisher,
    "developer": developer,
    "release_date":
        "${releaseDate.year.toString().padLeft(4, '0')}-${releaseDate.month.toString().padLeft(2, '0')}-${releaseDate.day.toString().padLeft(2, '0')}",
    "freetogame_profile_url": freetogameProfileUrl,
    "minimum_system_requirements": (minimumSystemRequirements != null)
        ? minimumSystemRequirements!.toJson()
        : null,
    "screenshots": List<dynamic>.from(screenshots.map((x) => x.toJson())),
  };
}

class MinimumSystemRequirements {
  String os;
  String processor;
  String memory;
  String graphics;
  String storage;

  MinimumSystemRequirements({
    required this.os,
    required this.processor,
    required this.memory,
    required this.graphics,
    required this.storage,
  });

  factory MinimumSystemRequirements.fromRawJson(String str) =>
      MinimumSystemRequirements.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory MinimumSystemRequirements.fromJson(Map<String, dynamic> json) =>
      MinimumSystemRequirements(
        os: json["os"],
        processor: json["processor"],
        memory: json["memory"],
        graphics: json["graphics"],
        storage: json["storage"],
      );

  Map<String, dynamic> toJson() => {
    "os": os,
    "processor": processor,
    "memory": memory,
    "graphics": graphics,
    "storage": storage,
  };
}

class Screenshot {
  int id;
  String image;

  Screenshot({required this.id, required this.image});

  factory Screenshot.fromRawJson(String str) =>
      Screenshot.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory Screenshot.fromJson(Map<String, dynamic> json) =>
      Screenshot(id: json["id"], image: json["image"]);

  Map<String, dynamic> toJson() => {"id": id, "image": image};
}
