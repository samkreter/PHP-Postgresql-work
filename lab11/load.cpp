#include <iostream>
#include <sqlite3.h>
#include <fstream>
#include <string.h>


using namespace std;

int main(int argc, char** argv)
{
  // if(argc != 4)
  //   {
  //     std::cerr << "USAGE: " << argv[0] << " <database file> <table name> <CSV file>" << std::endl;
  //     return 1;
  //   }

  ifstream readFile(argv[3]);
  if(!readFile.is_open()){
    std::cout<<"file not able to be opened";
    return -1;
  }
  string line;
  sqlite3 *db;
  int rc;
  sqlite3_stmt * stmt;
  const char *zSql;
  string beginDel;
  string query;
  int s;


  //open the db connection
  rc = sqlite3_open(argv[1], &db);
  //check connection to database
  if(rc){
     std::cout<< "Can't open database: %s\n"<<sqlite3_errmsg(db);
     return 1;
  }else{
     std::cout<< "Opened database successfully\n";
  }

  //build the statment
  beginDel = string("DELETE FROM ") + string(argv[2]) + string(";");

  zSql = beginDel.c_str();

  //prepare statment for the delete
  sqlite3_prepare(db,zSql,strlen(zSql),&stmt,NULL);
  s = sqlite3_step (stmt);
  if(s == SQLITE_ERROR){
    cout<<"failed to delete table";
    return -1;
  }



  while(readFile >> line){

    query = string("INSERT INTO ") + string(argv[2])+string(" VALUES(")+line+string(");");

    zSql = query.c_str();

    sqlite3_prepare(db,zSql,strlen(zSql),&stmt,NULL);
    s = sqlite3_step(stmt);
    if(s == SQLITE_ERROR){
      cout<<"failed to insert values "<<line<<endl;
    }
  }





  sqlite3_finalize(stmt);
  readFile.close();
  sqlite3_close(db);


  return 0;
}
