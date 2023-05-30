/* eslint-disable @typescript-eslint/no-explicit-any */
import Album from "./AlbumModel";
import Request from "./RequestModel";
// import Storage from "./StorageModel";
export default class Song {
  //   public static getServerData() {}
  private static SONGS_URl_ALBUM = "http://127.0.0.1:8000/api/album/";
  private id!: number;
  private name!: string;
  private duration!: number;
  private preview!: string;
  public constructor(album: Album | undefined = undefined) {
    if (album !== undefined) Song.SONGS_URl_ALBUM += album.id + "/song";
  }
  setId(id: number) {
    this.id = id;
  }
  setName(name: string) {
    this.name = name;
  }
  setDuration(duration: number) {
    this.duration = duration;
  }
  setPreview(preview: string) {
    this.preview = preview;
  }
  getId() {
    return this.id;
  }
  getName() {
    return this.name;
  }
  getDuration() {
    return this.duration;
  }
  getPreview() {
    return this.preview;
  }
  public async getServerData() {
    const request = new Request();
    const result: Song[] = [];
    await request.Execute("GET", Song.SONGS_URl_ALBUM).then((response) => {
      if (typeof response !== "string") return;
      response = JSON.parse(response) as any;

      (response as any).forEach((item: any) => {
        const song = new Song();
        song.setId(item.id);
        song.setName(item.name);
        song.setPreview(item.preview);
        song.setDuration(item.duration);
        result.push(song);
      });
    });
    Song.SONGS_URl_ALBUM = "http://127.0.0.1:8000/api/album/";
    return result;
  }
}
