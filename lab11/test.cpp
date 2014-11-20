#include <iostream>
#include <sqlite3.h>
#include <string.h>

using namespace std;

int main(int argc, char** argv)
{


   sqlite3 *db;
   char *zErrMsg = 0;

   int rc;
   sqlite3_stmt * stmt;
   const char *zSql = "Select * from mytable;";
   int row = 1;
   const char * text;
   int columnNum = 0;
   int i = 0;


   rc = sqlite3_open("myDatabase.db", &db);

   if( rc ){
      std::cout<< "Can't open database: %s\n", sqlite3_errmsg(db);
      return 1;
   }else{
      std::cout<< "Opened database successfully\n";
   }



   sqlite3_prepare(db,zSql,strlen(zSql),&stmt,NULL);

    while (1) {
            int s;

            s = sqlite3_step (stmt);
            if (s == SQLITE_ROW) {
                int bytes;
                const unsigned char * text;
                bytes = sqlite3_column_bytes(stmt, 0);
                columnNum = sqlite3_column_count(stmt);

                text  = sqlite3_column_text (stmt, 0);
                std::cout<<row<<" "<<text;
                for(i=1;i<columnNum;i++){
                  text  = sqlite3_column_text (stmt, i);
                  std::cout<<" "<<text;
                }
                std::cout<<std::endl;
                row++;
            }
            else if (s == SQLITE_DONE) {
                break;
            }
            else {
                std::cout<< "Failed.\n";
                return -1;
            }
        }






   sqlite3_close(db);

  return 0;
}

//8821506
