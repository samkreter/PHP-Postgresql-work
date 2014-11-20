#include <iostream>
#include <sqlite3.h>
#include <string.h>
#include <fstream>

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
   const char * datatype;


   //file operations
   ofstream csvFile(argv[1]);
   if(!csvFile.is_open()){
     std::cout<<"file couldn't open";
     return -1;
   }


   rc = sqlite3_open("myDatabase.db", &db);
   //check connection to database
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

                for(i=0;i<columnNum;i++){

                  //if it is text put it in quotes
                  if(sqlite3_column_type(stmt,i) == SQLITE_TEXT){
                    text  = sqlite3_column_text (stmt, i);
                    csvFile<<"'"<<text<<"'";
                    //if last add newline otherwise a comma
                    if(i == columnNum - 1){
                      csvFile<<endl;
                    }
                    else{
                      csvFile<<",";
                    }

                  }
                  else if(sqlite3_column_type(stmt,i) == SQLITE_INTEGER){
                    text = sqlite3_column_text(stmt,i);
                    csvFile<<text;
                    //if last add newline otherwise a comma
                    if(i == columnNum - 1){
                      csvFile<<endl;
                    }
                    else{
                      csvFile<<",";
                    }

                  }
                  else{
                    cout<<"not type int or varchar"<<endl;
                  }


                  std::cout<<" "<<text<<" "<<datatype;
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
