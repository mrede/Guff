require 'rubygems' # not necessary with ruby 1.9 but included for completeness
require 'sinatra'
require "sinatra/reloader" if development?
require 'data_mapper'
require 'json'
require 'rack/contrib/jsonp'

use Rack::JSONP

configure :development do
  DataMapper.setup :default, "sqlite://#{Dir.pwd}/development.db"
end

configure :production do
end

class Message
  include DataMapper::Resource
  
  property :id, Serial
  property :ip, String
  property :message, String
  property :accuracy, String
  property :latitude, String
  property :longitude, String
  property :created_at, DateTime
  property :updated_at, DateTime
end

DataMapper.finalize
DataMapper.auto_upgrade!

get '/send/*' do
  
  @message = Message.create(
    :message      => CGI::unescape(params[:splat].first),
    :accuracy       => params[:accuracy],
    :latitude       => params[:latitude],
    :longitude       => params[:longitude],
    
    :created_at => Time.now
  )
  if @message.save
    content_type :json
    { :success_message => 'Message posted' }.to_json
  end
  
end