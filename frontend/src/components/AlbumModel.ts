/* eslint-disable @typescript-eslint/no-explicit-any */
import Request from "./RequestModel";
import Storage from "./StorageModel";
export default class Album {
  id!: number;
  name!: string;
  dateLaunch!: string;
  imageurl!: string;
  public static ALL_ALBUMS_URL = "http://127.0.0.1:8000/api/album";

  private static localStorage = {
    setAlbuns: (data: Album[]) => {
      Storage.setItem("albums", JSON.stringify(data));
    },
    getAlbuns: () => {
      const result = Storage.getItem("albums");
      if (result !== null) {
        return JSON.parse(result);
      }
      return null;
    },
    setExpireTime: () => {
      const result = new Date();
      result.setMinutes(result.getMinutes() + 1);
      Storage.setItem("expireTime", result.toString());
    },
    getExpireTime: () => {
      const date = Storage.getItem("expireTime");
      if (date !== null) return new Date(date);
      else return null;
    },
  };

  constructor(
    id: string | undefined = undefined,
    name: string | undefined = undefined,
    datelaunch: string | undefined = undefined,
    imageUrl: string | undefined = undefined
  ) {
    this.setName(name);
    this.setId(id);
    this.setImageUrl(imageUrl);
    this.setDateLaunch(datelaunch);
  }

  setName(name: string | undefined) {
    if (name == undefined) {
      return;
    }
    this.name = name;
  }
  setId(id: string | undefined) {
    if (id == undefined) {
      return;
    }
    this.id = Number(id);
  }
  setDateLaunch(dateLaunch: string | undefined) {
    if (dateLaunch == undefined) {
      return;
    }
    this.dateLaunch = dateLaunch;
  }
  setImageUrl(imageUrl: string | undefined) {
    if (imageUrl == undefined) {
      return;
    }
    this.imageurl = imageUrl;
  }
  public getName() {
    return this.name;
  }
  public getId() {
    return this.id;
  }
  public getDateLaunch() {
    return this.dateLaunch;
  }
  public getImgUrl() {
    return this.imageurl;
  }
  public static async getAllAlbums() {
    let response: Album[] = [];
    const expireTime = this.localStorage.getExpireTime();
    if (
      this.localStorage.getAlbuns() == null ||
      expireTime == null ||
      (expireTime !== null && expireTime < new Date())
    ) {
      response = await this.getServerData().then();
      this.localStorage.setAlbuns(response);
    } else response = this.localStorage.getAlbuns();
    return response;
  }
  private static async getServerData() {
    const request = new Request();
    const result = await request
      .Execute("GET", this.ALL_ALBUMS_URL)
      .then((response) => {
        if (typeof response !== "string") return;
        response = JSON.parse(response) as any;
        const result: Album[] = [];
        (response as any).forEach((item: any) => {
          const album = new Album(
            item["id"],
            item["name"],
            item["dateLaunch"],
            item["image"]
          );
          result.push(album);
        });
        return result;
      });
    return result;
  }
  public async save(imageObject = false) {
    const request = new Request();
    if (
      this.name == undefined ||
      this.dateLaunch == undefined ||
      this.imageurl == undefined
    )
      return;
    let formData;
    if (imageObject) {
      formData = Request.transformElementsFormData({
        name: this.name,
        dateLaunch: this.dateLaunch,
        image: this.imageurl,
      });
    } else {
      formData = Request.transformElementsFormData({
        name: this.name,
        dateLaunch: this.dateLaunch,
        image_url: this.imageurl,
      });
    }
    request.Execute("POST", Album.ALL_ALBUMS_URL, formData).then();
  }
  //   transformJsonInObject(object: string) {
  //     if (typeof object == "string") {
  //       object = JSON.stringify(object);
  //     }
  //   }
}
